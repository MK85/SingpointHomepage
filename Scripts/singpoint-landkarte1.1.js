$(function(){
    var map,
    markers = [
        {latLng: [50.77, 6.08], name: 'Aachen'},
        {latLng: [48.37, 10.90], name: 'Augsburg', labelPos: [7,-8]},
        {latLng: [52.50, 13.39], name: 'Berlin'},
        {latLng: [53.56, 10.00], name: 'Hamburg'},
        {latLng: [48.13, 11.56], name: 'München', labelPos: [-44,-4]},
        {latLng: [50.95, 6.96], name: 'Köln'},
        {latLng: [50.11, 8.68], name: 'Frankfurt'},
        {latLng: [48.77, 9.17], name: 'Stuttgart'},
        {latLng: [51.23, 6.78], name: 'Düsseldorf'},
        {latLng: [51.51, 7.46], name: 'Dortmund'},
        {latLng: [51.45, 7.01], name: 'Essen'},
        {latLng: [53.07, 8.80], name: 'Bremen'},
        {latLng: [52.02, 8.53], name: 'Bielefeld'},
        {latLng: [50.73, 7.09], name: 'Bonn', labelPos: [7,-4]},
        {latLng: [50.82, 12.92], name: 'Chemnitz', labelPos: [-44,-2]},
        {latLng: [49.87, 8.65], name: 'Darmstadt', labelPos: [-51,-4]},
        {latLng: [51.05, 13.74], name: 'Dresden', labelPos: [5,-12]},
        {latLng: [51.43, 6.76], name: 'Duisburg'},
        {latLng: [50.98, 11.03], name: 'Erfurt'},
        {latLng: [47.99, 7.84], name: 'Freiburg'},
        {latLng: [52.37, 9.73], name: 'Hannover'},
        {latLng: [49.01, 8.38], name: 'Karlsruhe'},
        {latLng: [54.32, 10.12], name: 'Kiel', labelPos: [-22,-6]},
        {latLng: [50.36, 7.58], name: 'Koblenz'},
        {latLng: [51.34, 12.37], name: 'Leipzig'},
        {latLng: [52.13, 11.62], name: 'Magdeburg'},
        {latLng: [49.48, 8.46], name: 'Mannheim'},
        {latLng: [51.18, 6.43], name: 'Mönchengladbach'},
        {latLng: [51.96, 7.62], name: 'Münster', labelPos: [-8,-17]},
        {latLng: [49.45, 11.07], name: 'Nürnberg'},
        {latLng: [51.71, 8.75], name: 'Paderborn'},
        {latLng: [49.01, 12.10], name: 'Regensburg'},
        {latLng: [54.08, 12.10], name: 'Rostock'},
        {latLng: [50.88, 8.02], name: 'Siegen'},
        {latLng: [49.75, 6.63], name: 'Trier'},
        {latLng: [48.40, 9.97], name: 'Ulm', labelPos: [-24,-6]},
        {latLng: [50.06, 8.24], name: 'Wiesbaden', labelPos: [-53,-6]},
        {latLng: [51.25, 7.15], name: 'Wuppertal'},
        {latLng: [49.79, 9.95], name: 'Würzburg'}
    ];
    var istPunktAusserhalbDerKarte = function(punkt){
        return punkt.x < 0 || punkt.x > 307 || punkt.y < 0 || punkt.y > 350;
    };
    var setOverlays = function () {
        var mapObj = $('#map').vectorMap('get', 'mapObject');
        var coord, name, offset, punktX, punktY;
        for (var i = 0; i < markers.length; i++) {
            coord = mapObj.getMarkerPosition(markers[i]);
            name = markers[i].name;
            offset = markers[i].labelPos;
            $('#singpointLandkarte' + name).css('left', coord.x - 4);
            $('#singpointLandkarte' + name).css('top', coord.y - 6);

            if(istPunktAusserhalbDerKarte(coord)){
                $('#karteTextlabel' + name).hide()
            }
            else{
                $('#karteTextlabel' + name).show();
                $('#karteTextlabel' + name).css('left', coord.x + (offset?offset[0]:8));
                $('#karteTextlabel' + name).css('top', coord.y + (offset?offset[1]:-6));
            }
        }
    };

    map = new jvm.WorldMap({
        container: $('#map'),
        map: 'de_mill_en',
        backgroundColor: '#ffffff',
        regionsSelectable: false,
        markersSelectable: false,
        zoomOnScroll: true,
        markers: markers,
        markerStyle: {
            initial: {
                fill: '#fe0000',
                r: 5,
                stroke: '#ffffff',
                "stroke-opacity": 1,
                "stroke-width": 0
            },
            hover: {
                stroke: '#ffffff',
                "fill-opacity": 1,
                "stroke-width": 2,
                "stroke-opacity": 1
            }
        },
        regionStyle: {
            initial: {
                fill: '#aaa',
                stroke: '#fff',
                "fill-opacity": 1,
                "stroke-width": 0,
                "stroke-opacity": 0
            },
            hover: {
                fill: '#ccc',
                "fill-opacity": 1
            }
        },
        onViewportChange: setOverlays
    });
    map.setSelectedRegions( JSON.parse( window.localStorage.getItem('jvectormap-selected-regions') || '[]' ) );
    map.setSelectedMarkers( JSON.parse( window.localStorage.getItem('jvectormap-selected-markers') || '[]' ) );


    setOverlays();
    $('.singpointLandkarteJpeg').hide();
    $('#map[class!="singpointLandkarteNeutral"] .superlabel').mouseenter(function(){
        topbefore = parseInt($(this).css('top'));
        leftbefore = parseInt($(this).css('left'));
        $(this).css({'top': topbefore-68});
        $(this).css({'left': leftbefore-95});
    }).mouseleave(function(){
        $(this).css({'top': topbefore});
        $(this).css({'left': leftbefore});
    });
    $('#map[class="singpointLandkarteNeutral"] .superlabel').mouseenter(function(){
        topbefore = parseInt($(this).css('top'));
        leftbefore = parseInt($(this).css('left'));
        $(this).css({'top': topbefore-78});
        $(this).css({'left': leftbefore-95});
    }).mouseleave(function(){
            $(this).css({'top': topbefore});
            $(this).css({'left': leftbefore});
        });
});