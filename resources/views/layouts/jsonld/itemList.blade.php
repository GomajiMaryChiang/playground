<!-- jsonld -->
<script type="application/ld+json">
{
    @if (!empty($jsonld['type']) && ($jsonld['type'] == 'Channel' || $jsonld['type'] == 'Index' || $jsonld['type'] == 'Store' || $jsonld['type'] == 'Coffee' || $jsonld['type'] == 'Brand' || $jsonld['type'] == 'BrandList' || $jsonld['type'] == 'Category' || $jsonld['type'] == 'Special' || $jsonld['type'] == 'SpecialList' || $jsonld['type'] == '510' || $jsonld['type'] == 'ChSpecial' || $jsonld['type'] == 'Search' || $jsonld['type'] == 'Earnpoint' || $jsonld['type'] == 'EsForeign'))
        "@context":"https://schema.org",
        "@type":"{{ $jsonld['itemList']['jsonldType'] }}",
        "itemListElement":[{!! $jsonld['itemList']['list'] !!}]

    @endif
}
</script>

<!-- END jsonld -->
