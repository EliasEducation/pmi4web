const vd = function(value){
	console.log(value);
}

let slidersData = [
	[0, 'active', 'https://pbs.twimg.com/profile_images/1173161429266030592/lJCNA_JC_400x400.jpg'],
	[1, 'default','https://scientificrussia.ru/images/b/teb-full.jpg'],
	[2, 'default','https://ichef.bbci.co.uk/news/640/cpsprodpb/14A82/production/_116301648_gettyimages-1071204136.jpg'],
	[3, 'default','https://rozetked.me/images/uploads/dwoilp3BVjlE.jpg']
];

let $sliderWrapper = $('.slider_wrapper');
let $slides = $('.slides', $sliderWrapper);
let $nav = $('.nav', $sliderWrapper);
let $preview = $('.preview_slides', $sliderWrapper);
let slideCount = slidersData.length;
let currentSlide = 1;

let goToSlide = function(){
	let translateValue = -$('.slider_view').width() * currentSlide;

	if (currentSlide == slideCount || currentSlide <= 0 || currentSlide > slideCount) {
		translateValue = 0;
		currentSlide = 1;

		$slides.css({'transform': `translateX(${translateValue}px)`});

		return;
	}

	$slides.css({'transform': `translateX(${translateValue}px)`});

	currentSlide++;
};

let goToPrevSlide = function(){
	translateValue = -$('.slider_view').width() * (currentSlide - 2);

	if (currentSlide == 1 || currentSlide <= 0 || currentSlide > slideCount) {
		translateValue = -$('.slider_view').width() * (slideCount - 1);
		currentSlide = slideCount;

		$slides.css({'transform': `translateX(${translateValue}px)`});

		return;
	}

	$slides.css({'transform': `translateX(${translateValue}px)`});

	currentSlide--;
};

let setActiveNavItem = function(){
	$('img', $preview).removeClass('active');
	$(`img[data-slide_number="${currentSlide-1}"`, $preview).addClass('active');
};

$(function(){
	$.map(slidersData, (src) => {
		let slideHtml = `<img class="slide ${src[1]}" src="${src[2]}" data-slide_number="${src[0]}">`;

		$slides.append(slideHtml);
		$preview.append(slideHtml);

	});

	$('img', $preview).on('click', function(){
		currentSlide = $(this).data('slide_number');

		goToSlide();
		setActiveNavItem();
	});

	$('.btn', $sliderWrapper).on('click', function(e){
		let $btn = $(e.currentTarget);
		let action = $btn.data('action');

		switch(action){
			case 'go_next':
				goToSlide();

				break;
			case 'go_prev':
				goToPrevSlide();

				break;
		}

		setActiveNavItem();
	});

	$slides.on('click', function(e){
		$('.popup').show();

		let content = `<img class="inner_content" src="${slidersData[currentSlide - 1][2]}">`

		$('.slide_content').html(content);
	});

	$('.popup_background').on('click', function(e){
		$(this).closest('.popup').hide();
	})

	let timeInterval = setInterval(function(){
		goToSlide();
		setActiveNavItem();
	}, 2000);

	$('.slider_view').hover(function(){
		clearInterval(timeInterval);
	}, function(){
		timeInterval = setInterval(function(){
			goToSlide();
			setActiveNavItem();
		}, 2000);
	});
});









