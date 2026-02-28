<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0">
  <channel>
    <title>{{ config('app.name') }} Blog</title>
    <link>{{ url('/') }}</link>
    <description>Latest posts from the blog</description>
    <lastBuildDate>{{ now()->toRfc2822String() }}</lastBuildDate>
    <language>{{ str_replace('_','-',app()->getLocale()) }}</language>

    @foreach($blogs as $post)
      <item>
        <title>{{ $post->title }}</title>
        <link>{{ url(route('blog.show', $post->slug, false)) }}</link>
        <guid isPermaLink="true">{{ url(route('blog.show', $post->slug, false)) }}</guid>
        <pubDate>{{ optional($post->published_at ?? $post->created_at)->toRfc2822String() }}</pubDate>
        <description><![CDATA[{!! $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->content), 200) !!}]]></description>
      </item>
    @endforeach
  </channel>
</rss>
