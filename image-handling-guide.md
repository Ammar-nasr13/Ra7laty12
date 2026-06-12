# دليل حفظ الصور في المشروع

## المكتبتان المستخدمتان

| المكتبة | الاستخدام |
|---|---|
| `spatie/laravel-medialibrary` | حفظ الصور وإدارتها بشكل متقدم |
| `spatie/laravel-translatable` | حفظ النصوص (وليس الصور) بأكثر من لغة |

---

## أولاً: Spatie MediaLibrary — حفظ الصور

### كيف تعمل؟

MediaLibrary تحفظ الصور في جدول `media` وتربطها بأي موديل عبر polymorphic relation.
الصور تُخزَّن في `storage/app/public/` وتُعرض عبر symlink.

### 1. إعداد الموديل

```php
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * تعريف المجموعات (Collections) — كل مجموعة تمثل نوع صورة مختلف.
     */
    public function registerMediaCollections(): void
    {
        // صورة واحدة فقط (singleFile) — تُستبدل القديمة تلقائياً
        $this->addMediaCollection('main_image')
            ->singleFile()
            ->useFallbackUrl(asset('admin2/assets/img/products/2.jpg'));

        // مجموعة صور متعددة (gallery)
        $this->addMediaCollection('gallery')
            ->useFallbackUrl(asset('admin2/assets/img/products/2.jpg'));
    }
}
```

> **`singleFile()`** → يضمن وجود صورة واحدة فقط في المجموعة.  
> **`useFallbackUrl()`** → يعيد هذا الرابط إذا لم توجد صورة.

---

### 2. حفظ الصورة في Controller

#### الطريقة الأسرع — من Request مباشرة

```php
// store()
if ($request->hasFile('logo')) {
    $brand->addMediaFromRequest('logo')
        ->toMediaCollection('logo');
}
```

`addMediaFromRequest('logo')` → اسم الـ input في الـ form.  
`toMediaCollection('logo')` → اسم المجموعة في الموديل.

---

#### الطريقة اليدوية — من ملف مُحمَّل مسبقاً

```php
if (isset($variantData['primary_image'])) {
    $variant->addMedia($variantData['primary_image'])
        ->toMediaCollection('primary_image');
}
```

مفيدة عند معالجة ملفات من array (مثل variants).

---

#### حفظ صور متعددة (gallery)

```php
if (isset($variantData['gallery_images'])) {
    foreach ($variantData['gallery_images'] as $image) {
        $variant->addMedia($image)
            ->toMediaCollection('gallery_images');
    }
}
```

---

### 3. تحديث الصورة في update()

```php
if ($request->hasFile('logo')) {
    // حذف القديمة أولاً
    $brand->clearMediaCollection('logo');
    // رفع الجديدة
    $brand->addMediaFromRequest('logo')
        ->toMediaCollection('logo');
}
```

> إذا كانت المجموعة `singleFile()` فـ MediaLibrary تستبدل القديمة تلقائياً،
> لكن نكتب `clearMediaCollection()` بشكل صريح للوضوح.

---

### 4. حذف صورة واحدة بـ ID

```php
// حذف media بعينها (مثلاً من قائمة deleted_media)
$deletedMedia = $request->input('deleted_media', []);
foreach ($deletedMedia as $mediaId) {
    $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($mediaId);
    if ($media) {
        $media->delete();
    }
}
```

---

### 5. إعادة ترتيب صور Gallery

```php
if (isset($variantData['existing_gallery_order']) && is_array($variantData['existing_gallery_order'])) {
    \Spatie\MediaLibrary\MediaCollections\Models\Media::setNewOrder(
        $variantData['existing_gallery_order'] // مصفوفة IDs بالترتيب الجديد
    );
}
```

---

### 6. عرض الصورة في Blade

```blade
{{-- صورة واحدة --}}
<img src="{{ $brand->getFirstMediaUrl('logo') }}" alt="Logo">

{{-- مع fallback --}}
<img src="{{ $brand->getFirstMediaUrl('logo') ?: asset('default.jpg') }}" alt="Logo">

{{-- جميع صور gallery --}}
@foreach ($product->getMedia('gallery') as $media)
    <img src="{{ $media->getUrl() }}" alt="Gallery Image">
@endforeach

{{-- الحصول على كائن Media --}}
$mediaItem = $model->getFirstMedia('collection_name');
$url       = $mediaItem->getUrl();
$id        = $mediaItem->id;
```

---

### 7. Eager Loading للصور (تجنب N+1)

```php
// في Controller
$products = Product::with([
    'variants' => function ($query) {
        $query->with(['media']);
    },
])->get();
```

---

### نماذج من المشروع

| الموديل | المجموعات |
|---|---|
| `Brand` | `logo` — صورة واحدة |
| `Category` | `logo` — صورة واحدة |
| `Product` | `main_image` (واحدة) + `gallery` (متعددة) |
| `ProductVariant` | `primary_image` (واحدة) + `gallery_images` (متعددة) |
| `Service` | `image` — صورة واحدة |
| `Slider` | `image` — صورة واحدة |

---

## ثانياً: الطريقة البديلة — Storage مباشر (Banner)

موديل `Banner` لا يستخدم MediaLibrary، بل يحفظ الصورة يدوياً في `BannerService`:

```php
protected function uploadImage($file): string
{
    $directory = public_path('storage/banners');
    $filename  = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $file->move($directory, $filename);

    return 'banners/' . $filename; // المسار المحفوظ في قاعدة البيانات
}

protected function deleteImage(string $imagePath): bool
{
    $fullPath = public_path('storage/' . $imagePath);

    if (file_exists($fullPath)) {
        return unlink($fullPath);
    }

    return Storage::disk('public')->delete($imagePath);
}
```

> الفرق: هذه الطريقة تحفظ المسار كـ string في عمود `image` في الجدول.
> MediaLibrary أفضل لأنها تدير الحذف والـ fallback تلقائياً.

---

## ثالثاً: Spatie Translatable — الحقول متعددة اللغات

### الإعداد في الموديل

```php
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    // الحقول التي تدعم أكثر من لغة
    public $translatable = ['name', 'description'];
}
```

تُخزَّن القيم كـ JSON في قاعدة البيانات:
```json
{"en": "Blue T-Shirt", "ar": "تيشيرت أزرق"}
```

---

### الحفظ في store()

يتطلب أن يُرسَل الحقل كمصفوفة من الـ form:

```blade
{{-- في Blade Form --}}
<input name="name[en]" value="English Name">
<input name="name[ar]" value="الاسم بالعربي">
```

```php
// في Controller — مباشر بدون معالجة
$product = Product::create($request->validated());
// name يصل كـ ['en' => '...', 'ar' => '...'] ويُحفظ تلقائياً كـ JSON
```

---

### الحفظ اليدوي بـ setTranslation

```php
$product->setTranslation('name', 'en', 'Blue T-Shirt');
$product->setTranslation('name', 'ar', 'تيشيرت أزرق');
$product->save();
```

---

### القراءة

```php
// حسب اللغة الحالية (app()->getLocale())
$product->name;

// لغة محددة
$product->getTranslation('name', 'ar');
$product->getTranslation('name', 'en');

// جميع اللغات
$product->getTranslations('name');
// => ['en' => 'Blue T-Shirt', 'ar' => 'تيشيرت أزرق']
```

---

### البحث في حقل translatable

```php
// البحث داخل JSON
Service::where('title->en', 'like', "%{$search}%")
    ->orWhere('title->ar', 'like', "%{$search}%")
    ->get();
```

---

### الموديلات التي تستخدم Translatable في المشروع

| الموديل | الحقول المترجمة |
|---|---|
| `Product` | `name`, `description` |
| `Category` | `name` |
| `Brand` | `name` |
| `Service` | `title`, `description` |
| `Banner` | `title`, `description`, `badge` |
| `ProductVariant` | `name` |
| `Variant` | `name` |

---

## الفرق الجوهري بين المكتبتين

| | MediaLibrary | Translatable |
|---|---|---|
| **ماذا تحفظ؟** | الصور والملفات | النصوص فقط |
| **أين تحفظ؟** | جدول `media` منفصل | نفس العمود بالجدول (JSON) |
| **الحذف** | تلقائي مع الموديل | لا يوجد ملف يُحذف |
| **الـ Fallback** | `useFallbackUrl()` | لا ينطبق |
| **عرض القيمة** | `getFirstMediaUrl('collection')` | `$model->field` |

---

## مثال كامل — موديل يجمع الاثنين معاً (Service)

```php
// الموديل
class Service extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations;

    public $translatable = ['title', 'description'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }
}
```

```php
// store() في Controller
public function store(ServiceRequest $request): RedirectResponse
{
    $data = $request->validated();
    // title و description يصلان كـ ['en' => ..., 'ar' => ...] ويُحفظان تلقائياً
    $service = Service::create($data);

    if ($request->hasFile('image')) {
        $service->addMediaFromRequest('image')
            ->toMediaCollection('image');
    }

    return redirect()->route('admin.services.list');
}
```

```php
// update() في Controller
public function update(ServiceRequest $request, int $id): RedirectResponse
{
    $service = Service::findOrFail($id);
    $service->update($request->validated());

    if ($request->hasFile('image')) {
        $service->clearMediaCollection('image');
        $service->addMediaFromRequest('image')
            ->toMediaCollection('image');
    }

    return redirect()->route('admin.services.list');
}
```

```blade
{{-- عرض في Blade --}}
<h3>{{ $service->title }}</h3>  {{-- اللغة الحالية تلقائياً --}}
<img src="{{ $service->getFirstMediaUrl('image') }}" alt="{{ $service->title }}">
```
