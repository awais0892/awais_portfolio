<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>{{ url('/') }}</loc>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
  </url>
  @foreach($blogs as $post)
    <url>
      <loc>{{ url(route('blog.show', $post->slug, false)) }}</loc>
      <lastmod>{{ optional($post->published_at ?? $post->updated_at)->toAtomString() }}</lastmod>
      <changefreq>weekly</changefreq>
      <priority>0.7</priority>
    </url>
  @endforeach
</urlset>
