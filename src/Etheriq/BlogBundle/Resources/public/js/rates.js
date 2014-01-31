jQuery(function(){

    var rateContainer = $("#rates"),
        minRating = rateContainer.data('min-rating'),
        maxRating = rateContainer.data('max-rating'),
        rateStep = rateContainer.data('step'),
        prototypeStar = $("#prototype-star").detach().prop("id", ""),
        memoryStarIndex = 0,
        rated = false,
        rateStars = createRatingStars(rateContainer, prototypeStar,minRating, maxRating, rateStep),
        rating;

    rateContainer.on('mouseover', 'li', function(){

        var indexOfRate = $(this).index();
        setRatesStars(indexOfRate);

    });

    rateContainer.on('mouseout', 'li', function(){

        if(rated){
            setRatesStars(memoryStarIndex);
        }
        else{
            clearRates();
        }

    });
    rateContainer.on('click', 'li', function(){

        memoryStarIndex = $(this).index();
        rating = this.rating;
        rated = true;
        setRatesStars(memoryStarIndex);
//        console.log('Your rate is '+rating);
        $('#blog_rating').prop({"value" : rating });

    });

//region==================== Utils ========================

    function setRatesStars(starIndex){

        var
            countStars = rateStars.length,
            rateType = 'defaultRating';

        if(starIndex <= countStars/3){
            rateType = 'badRating';
        }
        if((starIndex >= countStars/3)&&(starIndex <= countStars*2/3)){
            rateType = 'rating';
        }
        if((starIndex >= countStars*2/3)&&(starIndex<=countStars)){
            rateType = 'coolRating';
        }

        for(var i = 0; i < rateStars.length; i++){
            if(i <= starIndex){
                rateStars.eq(i).removeClass();
                rateStars.eq(i).addClass(rateType);
            }
            else{
                rateStars.eq(i).removeClass();
                rateStars.eq(i).addClass('defaultRating');
            }
        }
    }
    function clearRates(){
        for(var i = 0; i < rateStars.length; i++){
            rateStars.eq(i).removeClass();
            rateStars.eq(i).addClass('defaultRating');
        }
    }
    function createRatingStars(rateContainer, prototypeStar, minRating, maxRating, rateStep){

        var currentNode;

        for(var i = minRating; i <= maxRating; i+=rateStep){

            currentNode = prototypeStar.clone();
            currentNode[0].rating = i;
            rateContainer.append(currentNode);

        }
        return rateContainer.find('li');
    }
});

//endregion