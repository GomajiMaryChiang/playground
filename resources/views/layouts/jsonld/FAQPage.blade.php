<!-- jsonld -->
<script type="application/ld+json">
{
    @if (!empty($jsonld['type']) && $jsonld['type'] == 'Help')
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [{!! $jsonld['mainEntity']['list'] !!}]
    @endif
}
</script>

<!-- END jsonld -->