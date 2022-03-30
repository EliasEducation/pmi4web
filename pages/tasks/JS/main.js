const vd = function(value){
	console.log(value);
};

$(function(){
	// task 1 - 2
	$('.task_1 [data-action="count_sum"]').on('click', function(e){
		let inputs = $('.task_1 #sum_number');
		let $inputSum = $('.task_1 #sum');

		$.map(inputs, (input) => {
			$($inputSum).val($($inputSum).val() * 1 + $(input).val() * 1);
		});
	});

	// task 3
	$('.task_3 #number').on('blur', function(e){
		let target = e.currentTarget;
		let $inputSum = $('.task_3 #sum');

		$inputSum.val(0);
		$(target).val().split('').forEach((number) => $inputSum.val($inputSum.val() * 1 + number * 1));
	});

	// task 4
	$('.task_4 #number').on('blur', function(e){
		let target = e.currentTarget;
		let $inputSum = $('.task_4 #sum');
		let sum = 0;

		$inputSum.val(0);
		$(target).val().split(',').forEach((number) => sum += number * 1);

		$inputSum.val(sum);
	});

	// task 5-6
	$('.task_5-6 #fio').on('blur', function(e){
		let target = e.currentTarget;
		var fio = '';

		$(target).val().split(' ').forEach((fioElement) => {
			if(fioElement) fio += fioElement[0].toUpperCase() + fioElement.substr(1) + ' ';
		});

		$(target).val(fio);
	});

	// task 7-8
	$('.task_7-8 #text').on('blur', function(e){
		let target = e.currentTarget;
		let $countSymbols = $('.task_7-8 #count_symbols');
		let $countWords = $('.task_7-8 #count_words');
		let maxSymbolsInWord = 0;
		let countWords = 0;
		let lastWord = '';


		$countSymbols.val('');
		$countWords.val('');
		$(target).val().split(' ').forEach((textElement) => {
			if(textElement){
				if(textElement.length > lastWord.length) maxSymbolsInWord = textElement.length;

				countWords += 1;

				lastWord = textElement;
			}
		});

		$countSymbols.val(maxSymbolsInWord);
		$countWords.val(countWords);
	});

	// task 9-10
	$('.task_9-10 #text').on('blur', function(e){
		let target = e.currentTarget;
		let $countYears = $('.task_9-10 #years');
		let currentYear = new Date().getTime();

		let inputYear = $(target).val();
		if(!inputYear) return;
		inputYear = inputYear.split('.').reverse().join('-');

		$(target).val(inputYear);

		let countYears = Math.round((currentYear - new Date(inputYear).getTime()) / (1000 * 60 * 60 * 24 * 365));
		$countYears.val(countYears);
	});

	// раздел 2
	// task 11
	$('.task_11 a.targetLink').on('click', function(e){
		e.preventDefault();

		$('.task_11 input:checkbox').prop('checked', !$('.task_11 input:checkbox').is(':checked'));
	});

	// task 12
	$('.task_12 .targetButton').on('click', function(e){
		$('.task_12 input:checkbox').prop('checked', !$('.task_12 input:checkbox').is(':checked'));
	});

	// task 13
	$('.task_13 input:radio').on('click', function(e){
		$('.task_13 .lang').text($(e.currentTarget).val());
	});

	// task 14-15
	$('.task_14 input:checkbox, .task_15 input:checkbox').on('change', function(e){
		if($(this).is(':checked')){
			$(this).next().show();
		}else{
			$(this).next().hide();
		}
	});

	// task 16
	$('.task_16 input:checkbox').on('change', function(e){
		let $text = $('.task_16 .text');

		if($(this).is(':checked')){
			let styleName = $(this).data('text_style').substr(0, $(this).data('text_style').indexOf(':'));
			let styleValue = $(this).data('text_style').substr($(this).data('text_style').indexOf(':') + 1);

			let styles = new Object();
			styles[styleName] = styleValue;

			$text.css(styles);
		}else{
			let styleName = $(this).data('text_style').substr(0, $(this).data('text_style').indexOf(':'));
			$text.css(styleName, 'unset');
		}
	});

	// task 17
	$('.task_17 input').on('change', function(e){
		if(!$(this).val().length) return

		let counties = $(this).val().split(',');

		$('.task_17 .countries_list').html('');
		counties.forEach(function(county){
			if(!county.trim().length) return;

			let li = `<li>${county.trim()}</li>`
			$('.task_17 .countries_list').append(li);
		});
	});

	// task 18
	$('.task_18 .country').on('click', function(e){
		if($('.cities_list', $(this)).is(':visible')){
			$('.cities_list', $(this)).hide();
		}else{
			$('.cities_list', $(this)).show();
		}
	});

	// task 19
	let citiesByCountries = {
		rus: ['MSK', 'SPB', 'NSK'],
		usa: ['Нью‑Йорк', 'Лос‑Анджелес', 'Чикаго'],
		ch: ['Шанхай ', 'Чунцин ', 'Пекин '],
	}
	$('.task_19 select').on('change', function(e){
		let $citiesSelect = $('.task_19 .cities');
		let options = '';

		if($(this).is('.countries')){
			citiesByCountries[$('option:selected', $(this)).data('country')].forEach(function(country){
				options += `<option class="city">${country}</option>`;
			});

			$citiesSelect.html(options);
		}

		let currentCountry = $('.task_19 .countries option:selected').text();
		let currentCity = $('.task_19 .cities option:selected').text();

		$('.task_19 .text').html(`${currentCountry}, ${currentCity}`)
	});

	// task 20

	let currencyExchange = {
		usdRub: 73,
		rubUsd: 0.013,
		rubKz: 5.94,
		kzRub: 0.17,
		kzUsd: 0.0023,
		usdKz: 435.67,
	}
	$('.task_20 select').on('change', function(e){

		let cash = $('.task_20 .cash').val();
		let selects = $('.task_20 select');

		let exchangeNaem = $(selects[0]).val() + $(selects[1]).val()[0].toUpperCase() + $(selects[1]).val().substr(1);

		let $secondSelect = $(this).siblings('.currencies');

		$(this).children('option').prop('disabled', false);

		$secondSelect.children('option').prop('disabled', false);
		$secondSelect.val($(`option:not(:disabled):not([value="${$(this).val()}"])`, $secondSelect)[0].value);

		$(this).children(`[value="${$secondSelect.val()}"]`).prop('disabled', true);
		$secondSelect.children(`[value="${$(this).val()}"]`).prop('disabled', true);

		$('.task_20 .res').text(currencyExchange[exchangeNaem] * cash);
	});
});