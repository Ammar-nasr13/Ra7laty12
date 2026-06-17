<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">

  <url>
    <loc>{{ url('/') }}</loc>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
    <xhtml:link rel="alternate" hreflang="ar" href="{{ url('/') }}?locale=ar"/>
    <xhtml:link rel="alternate" hreflang="en" href="{{ url('/') }}?locale=en"/>
  </url>

  <url>
    <loc>{{ route('destinations.index') }}</loc>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>

  <url>
    <loc>{{ route('survey.index') }}</loc>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
  </url>

  @foreach($trips as $trip)
  <url>
    <loc>{{ route('trips.show', $trip->id) }}</loc>
    <lastmod>{{ $trip->updated_at->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.9</priority>
  </url>
  @endforeach

  @foreach($destinations as $destination)
  <url>
    <loc>{{ route('destinations.show', $destination->id) }}</loc>
    <lastmod>{{ $destination->updated_at->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
  @endforeach

</urlset>
