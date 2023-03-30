<!-- jsonld -->
<script type="application/ld+json">
{
    @if (!empty($jsonld['type']) && $jsonld['type'] == 'Product')

        "@context": "https://schema.org/",
        "@type": "{{ $jsonld['product']['jsonldType'] }}",
        "name": "{{ $jsonld['product']['name'] }}",
        "image": [{!! $jsonld['product']['imgArray'] !!}],
        "description": "{{ $jsonld['product']['description'] }}",
        "sku": "{{ $jsonld['product']['sku'] }}",
        "mpn": "{{ $jsonld['product']['sku'] }}",
        "brand": {
            "@type": "Brand",
            "name": "{{ $jsonld['product']['brandName'] }}"
        },
        @if ($jsonld['product']['ratingValue'] > 0)
        "review": {
            "@type": "Review",
            "reviewRating": {
                "@type": "Rating",
                "ratingValue": "{{ $jsonld['product']['ratingValue'] }}",
                "bestRating": ""
            },
            "author": {
                "@type": "Organization",
                "name": "GOMAJI Corp., LTD"
            }
        },
        @endif

        @if ($jsonld['product']['ratingValue'] > 0)
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "{{ $jsonld['product']['ratingValue'] }}",
                "reviewCount": "{{ $jsonld['product']['reviewCount'] }}"
            },
        @endif

        "offers": {
            "@type": "Offer",
            "url": "{{ $jsonld['product']['offerUrl'] }}",
            "priceCurrency": "{{ $jsonld['product']['priceCurrency'] }}",
            "price": "{{ $jsonld['product']['price'] }}",
            "priceValidUntil": "{{ $jsonld['product']['priceValidUntil'] }}",
            "itemCondition": "https://schema.org/UsedCondition",
            "availability": "https://schema.org/InStock"
        }
        
    @endif
}
</script>

<!-- END jsonld -->