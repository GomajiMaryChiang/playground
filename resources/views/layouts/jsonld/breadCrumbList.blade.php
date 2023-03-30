<!-- jsonld -->
<script type="application/ld+json">
{
    @if (!empty($jsonld['type']) && empty($jsonld['breadCrumbList']['nameFor']) && ($jsonld['type'] == 'Product' || $jsonld['type'] == 'Store' || $jsonld['type'] == 'Contact' || $jsonld['type'] == 'BrandList' || $jsonld['type'] == 'Category' || $jsonld['type'] == 'Special' || $jsonld['type'] == 'ChSpecial' || $jsonld['type'] == 'EarnpointDetail'))
        "@context": "https://schema.org",
        "@type": "{{ $jsonld['breadCrumbList']['jsonldType'] }}",
        "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "GOMAJI夠麻吉",
            "item": "https://www.gomaji.com"
        },{
            "@type": "ListItem",
            "position": 2,
            "name": "{{ $jsonld['breadCrumbList']['nameSec'] }}",
            "item": "{{ $jsonld['breadCrumbList']['itemSec'] }}"
        },{
            "@type": "ListItem",
            "position": 3,
            "name": "{{ $jsonld['breadCrumbList']['nameThi'] }}",
            "item": "{{ $jsonld['breadCrumbList']['itemThi'] }}"
        }]
    @endif

    @if (!empty($jsonld['type']) && ($jsonld['type'] == 'Channel' || $jsonld['type'] == 'About' || $jsonld['type'] == 'Privacy' || $jsonld['type'] == 'Terms' || $jsonld['type'] == 'Help' || $jsonld['type'] == 'Coffee' || $jsonld['type'] == 'Brand' || $jsonld['type'] == 'SpecialList' || $jsonld['type'] == '510' || $jsonld['type'] == 'Search' || $jsonld['type'] == 'Kol' || $jsonld['type'] == 'Earnpoint' || $jsonld['type'] == 'App' || $jsonld['type'] == 'EsForeign'))
        "@context": "https://schema.org",
        "@type": "{{ $jsonld['breadCrumbList']['jsonldType'] }}",
        "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "GOMAJI夠麻吉",
            "item": "https://www.gomaji.com"
        },{
            "@type": "ListItem",
            "position": 2,
            "name": "{{ $jsonld['breadCrumbList']['nameSec'] }}",
            "item": "{{ $jsonld['breadCrumbList']['itemSec'] }}"
        }]
    @endif

    @if (!empty($jsonld['type']) && $jsonld['type'] == 'BrandList' && !empty($jsonld['breadCrumbList']['nameFor']))
        "@context": "https://schema.org",
        "@type": "{{ $jsonld['breadCrumbList']['jsonldType'] }}",
        "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "GOMAJI夠麻吉",
            "item": "https://www.gomaji.com"
        },{
            "@type": "ListItem",
            "position": 2,
            "name": "{{ $jsonld['breadCrumbList']['nameSec'] }}",
            "item": "{{ $jsonld['breadCrumbList']['itemSec'] }}"
        },{
            "@type": "ListItem",
            "position": 3,
            "name": "{{ $jsonld['breadCrumbList']['nameThi'] }}",
            "item": "{{ $jsonld['breadCrumbList']['itemThi'] }}"
        },{
            "@type": "ListItem",
            "position": 4,
            "name": "{{ $jsonld['breadCrumbList']['nameFor'] }}",
            "item": "{{ $jsonld['breadCrumbList']['itemFor'] }}"
        }]
    @endif
}
</script>

<!-- END jsonld -->
