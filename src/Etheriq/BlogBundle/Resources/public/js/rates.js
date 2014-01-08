jQuery(function($){

    var rateContainer = $('#rates'),
        rates = $('#rates>ul>li'),
        rated = false,
        rate = 1;

    rateContainer.on('mouseover', 'li', function(){

        var indexOfRate = $(this).index();
        setRatesStars(indexOfRate);

    });

    rateContainer.on('mouseout', 'li', function(){

        if(rated){
            setRatesStars(rate-1);
        }
        else{
            clearRates();
        }

    });

    rateContainer.on('click', 'li', function(){

        rate = $(this).index()+1;
        rated = true;
        setRatesStars(rate-1);
        // $('#rates>span').html('Your rate is '+rate);
        $('#blogDetailed_rating').prop({"value" : rate });
//        $('#rate-for-server').prop({"value" : rate });

    });

    function clearRates(){
        for(var i = 0; i < rates.length; i++){
            rates.eq(i).removeClass();
            rates.eq(i).addClass('defaultRating');
        }
    }

    function setRatesStars(rate){

        if(rate == 0){
            rates.eq(0).removeClass();
            rates.eq(0).addClass('badRating');
            for(var i = 1; i < rates.length; i++){
                rates.eq(i).removeClass();
                rates.eq(i).addClass('defaultRating');
            }
            return;
        }
        for(var i = 0; i < rates.length; i++){
            if(i <= rate){
                rates.eq(i).removeClass();
                rates.eq(i).addClass('rating');

            }
            else{
                rates.eq(i).removeClass();
                rates.eq(i).addClass('defaultRating');

            }
        }
    }

});
