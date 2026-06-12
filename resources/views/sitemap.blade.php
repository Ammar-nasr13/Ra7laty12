<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">

  <url>
    <loc>https://rahalaty.online/</loc>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
    <xhtml:link rel="alternate" hreflang="ar" href="https://rahalaty.online/"/>
    <xhtml:link rel="alternate" hreflang="en" href="https://rahalaty.online/"/>
  </url>

  <url>
    <loc>https://rahalaty.online/destinations</loc>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>

  <url>
    <loc>https://rahalaty.online/survey</loc>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
  </url>

  @foreach($trips as $trip)
  <url>
    <loc>https://rahalaty.online/trips/{{ $trip->id }}</loc>
    <lastmod>{{ $trip->updated_at->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.9</priority>
  </url>
  @endforeach

</urlset>
