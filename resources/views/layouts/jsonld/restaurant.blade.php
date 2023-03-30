<!-- jsonld -->
<script type="application/ld+json">
{
    @if (!empty($jsonld['type']) && $jsonld['type'] == 'Store')
        "@context": "https://schema.org",
        "@type": "{{ $jsonld['restaurant']['jsonldType'] }}",
        "image": ["{{ $jsonld['restaurant']['image'] }}"],
        "@id": "{{ $jsonld['restaurant']['id'] }}",
        "name": "{{ $jsonld['restaurant']['name'] }}",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ $jsonld['restaurant']['streetAddress'] }}",
            "addressLocality": "{{ $jsonld['restaurant']['addressLocality'] }}",
            "addressRegion": "{{ $jsonld['restaurant']['addressRegion'] }}",
            "addressCountry": "{{ $jsonld['restaurant']['addressCountry'] }}"
        },
        "review": {
            "@type": "Review",
            "reviewRating": {
                "@type": "Rating",
                "ratingValue": "{{ $jsonld['restaurant']['ratingValue'] }}",
                "bestRating": "{{ $jsonld['restaurant']['bestRating'] }}"
            },
            "author": {
                "@type": "Organization",
                "name": "GOMAJI Corp., LTD"
            }
        },
        "url": "{{ $jsonld['restaurant']['url'] }}",
        "telephone": "{{ $jsonld['restaurant']['telephone'] }}",
        "priceRange": "{{ $jsonld['restaurant']['priceRange'] }}",
        "menu": "{{ $jsonld['restaurant']['menu'] }}"
    @endif
}
</script>

<!-- END jsonld -->