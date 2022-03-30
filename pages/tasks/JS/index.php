<html>
<head>
	<meta charset="utf-8">
	<title>Js tasks</title>
	<link rel="stylesheet" href="../../../css/style.css">
	<link rel="stylesheet" href="../style.css">
</head>

<body>
	<?
	include '../../../template/header.php';
	?>
	<div class="wrapper">
		<div class="task_wrapper task_1">
			<i class="task_title">Задание 1-2</i>
			<div class="inputs_wrapper">
				<input type="number" id="sum_number" placeholder="Введите число">
				<input type="number" id="sum_number" placeholder="Введите число">
				<input type="number" id="sum_number" placeholder="Введите число">
				<input type="number" id="sum_number" placeholder="Введите число">
				<input type="number" id="sum_number" placeholder="Введите число">
			</div>

			<button data-action="count_sum">Сумма</button>
			<input type="number" id="sum" placeholder="Сумма">
		</div>

		<div class="task_wrapper task_3">
			<i class="task_title">Задание 3</i>
			<div class="inputs_wrapper">
				<input type="number" id="number" placeholder="Введите число">
			</div>

			<input type="number" id="sum" placeholder="Сумма">
		</div>

		<div class="task_wrapper task_4">
			<i class="task_title">Задание 4</i>
			<div class="inputs_wrapper">
				<input type="text" id="number" placeholder="Введите числа через запятую">
			</div>

			<input type="number" id="sum" placeholder="Сумма">
		</div>

		<div class="task_wrapper task_5-6">
			<i class="task_title">Задание 5-6</i>
			<div class="inputs_wrapper">
				<input type="text" id="fio" placeholder="Введите ФИО">
			</div>
		</div>

		<div class="task_wrapper task_7-8">
			<i class="task_title">Задание 7-8</i>
			<div class="inputs_wrapper">
				<input type="text" id="text" placeholder="Текст">

				<label>
					максимальное количество букв
					<input type="text" id="count_symbols" placeholder="Кол-во букв">
				</label>

				<label>
					количество слов
					<input type="text" id="count_words" placeholder="Кол-во слов">
				</label>

			</div>
		</div>

		<div class="task_wrapper task_9-10">
			<i class="task_title">Задание 9-10</i>
			<div class="inputs_wrapper">
				<input type="text" id="text" placeholder="Введите дату">

				<label>
					Кол-во лет
					<input type="text" id="years" placeholder="Кол-во лет">
				</label>

			</div>
		</div>

		<i class="task_title">Раздел 2</i>

		<div class="task_wrapper task_11">
			<i class="task_title">Задание 11</i>
			<a href="#" class="targetLink">Click</a>
			<div class="inputs_wrapper">
				<input type="checkbox">
			</div>
		</div>

		<div class="task_wrapper task_12">
			<i class="task_title">Задание 12</i>
			<button class="targetButton">Click</button>
			<div class="inputs_wrapper">
				<input type="checkbox">
				<input type="checkbox">
				<input type="checkbox">
			</div>
		</div>

		<div class="task_wrapper task_13">
			<i class="task_title">Задание 13</i>
			<div class="inputs_wrapper">
				<div>
					<label for="JS">JS</label>
					<input type="radio" id="JS" name="langRadio" value="JS">

					<label for="PHP">PHP</label>
					<input type="radio" id="PHP" name="langRadio" value="PHP">

					<label for="HTML">HTML</label>
					<input type="radio" id="HTML" name="langRadio" value="HTML">
				</div>

				<p class="lang"></p>
			</div>
		</div>

		<div class="task_wrapper task_14">
			<i class="task_title">Задание 14</i>
			<div class="inputs_wrapper">
				<input type="checkbox">
				<input type="text" style="display: none" placeholder="Меня видно">
			</div>
		</div>

		<div class="task_wrapper task_15">
			<i class="task_title">Задание 15</i>
			<div class="inputs_wrapper">
				<input type="checkbox">
				<p style="display: none">test1</p>
				<input type="checkbox">
				<p style="display: none">test2</p>
				<input type="checkbox">
				<p style="display: none">test3</p>
			</div>
		</div>

		<div class="task_wrapper task_16">
			<i class="task_title">Задание 16</i>
			<div class="inputs_wrapper">
				<label>
					Перечеркнуть
					<input type="checkbox" data-text_style="text-decoration:line-through">
				</label>
				<label>
					Сделать жирным
					<input type="checkbox" data-text_style="font-weight:bold">
				</label>
				<label>
					Сделать красным
					<input type="checkbox" data-text_style="color:red">
				</label>
			</div>
			<p class="text">test1</p>
		</div>

		<div class="task_wrapper task_17">
			<i class="task_title">Задание 17</i>
			<div class="inputs_wrapper">
				<label>
					Введите страны
					<input type="text" placeholder="Введите страны" ">
				</label>
			</div>
			Страны
			<ul class="countries_list" style="padding: 0; margin: 0;"></ul>
		</div>

		<div class="task_wrapper task_18">
			<i class="task_title">Задание 18</i>

			Страны
			<ul class="countries_list" style="padding: 0; margin: 0;">
				<li class="country" style="cursor: pointer">
					country1
					<ul class="cities_list" style="padding: 0; margin: 0 0 0 10px; display: none;">
						<li>city1</li>
						<li>city2</li>
						<li>city3</li>
						<li>city4</li>
					</ul>
				</li>
				<li class="country" style="cursor: pointer">
					country2
					<ul class="cities_list" style="padding: 0; margin: 0 0 0 10px; display: none;">
						<li>city1</li>
						<li>city2</li>
						<li>city3</li>
						<li>city4</li>
					</ul>
				</li>
			</ul>
		</div>

		<div class="task_wrapper task_19">
			<i class="task_title">Задание 19</i>

			Страны
			<select class="countries">
				<option class="country" data-country="rus" value="Россия">Россия</option>
				<option class="country" data-country="usa" value="США">США</option>
				<option class="country" data-country="ch" value="Китай">Китай</option>
			</select>

			Города
			<select class="cities">
				<option class="city">SPB</option>
				<option class="city">MSK</option>
				<option class="city">NSK</option>
			</select>

			<p class="text"></p>
		</div>

		<div class="task_wrapper task_20">
			<i class="task_title">Задание 20</i>

			Первая валюта
			<select class="currencies">
				<option class="currency" value="rub">rub</option>
				<option class="currency" value="usd" disabled>usd</option>
				<option class="currency" value="kz">kz</option>
			</select>

			Вторая валюта
			<select class="currencies">
				<option class="currency" value="rub" disabled>rub</option>
				<option class="currency" value="usd">usd</option>
				<option class="currency" value="kz">kz</option>
			</select>

			<input class="cash" placeholder="Введите сумму">

			<p class="res">123</p>
		</div>

	</div>
	<script
			src="https://code.jquery.com/jquery-3.6.0.min.js"
			integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			crossorigin="anonymous">
	</script>

	<script type="text/javascript" src="main.js"></script>
</body>
<!--<footer></footer>-->
</html>
