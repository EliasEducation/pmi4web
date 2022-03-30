const vd = function(value){
	console.log(value);
}

let slidersData = [
	[0, 'active', 'https://pbs.twimg.com/profile_images/1173161429266030592/lJCNA_JC_400x400.jpg'],
	[1, 'default','https://scientificrussia.ru/images/b/teb-full.jpg'],
	[2, 'default','https://ichef.bbci.co.uk/news/640/cpsprodpb/14A82/production/_116301648_gettyimages-1071204136.jpg'],
	[3, 'default','https://rozetked.me/images/uploads/dwoilp3BVjlE.jpg']
]

$(function(){
	let $sliderWrapper = $('.slider_wrapper');
	let $slides = $('.slides', $sliderWrapper);
	$.map(slidersData, (src) => {
		let html = `<img class="slide ${src[1]}" src="${src[2]}" data-slide_number="${src[0]}">`;

		$slides.append(html);
	});

	let $activeSlide = $('img.active', $slides);
	let translateValue = -($activeSlide.data('slide_number') - 1) * (parseInt($sliderWrapper.css('--active-slide-width')) / 2 + parseInt($activeSlide.css('margin-right')) / 2);

	if($activeSlide.data('slide_number') == 0) translateValue = (parseInt($sliderWrapper.css('--active-slide-width')) + parseInt($activeSlide.css('margin-right')) / 2);

	$slides.css({'transform': `translateX(${translateValue}px)`});

	$slides.on('click', function(e){
		let $currentSlide = $('img.active', $slides);
		let numberOfCurrentSlide = $currentSlide.data('slide_number');
		let nextSlide = $currentSlide.next();

		translateValue = -(numberOfCurrentSlide) * (parseInt($sliderWrapper.css('--active-slide-width')) + parseInt($currentSlide.css('margin-right')) / 2);
		if(!$(nextSlide).is('img')){
			nextSlide = $($currentSlide.siblings('img')[0]);
			translateValue = (parseInt($sliderWrapper.css('--active-slide-width')) + parseInt($activeSlide.css('margin-right')) / 2);
		}

		$('img', $slides).removeClass('active');

		nextSlide.addClass('active');

		$slides.css({'transform': `translateX(${translateValue}px)`});

	});
});









