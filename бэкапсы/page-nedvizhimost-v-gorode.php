<?php
get_header();
// Получите путь к директории дочерней темы
$child_theme_directory = get_stylesheet_directory();

// Укажите относительный путь к файлу, который вы хотите подключить
$include_file = 'assets/php/filter-query.php';

// Полный путь к файлу
$file_path = $child_theme_directory . '/' . $include_file;

// Проверьте существование файла перед подключением
if (file_exists($file_path)) {
	include $file_path;
} else {
	// Обработка ошибки, если файл не найден
	echo "Файл не найден: $file_path";
}
?>

<div class="_container"><?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs('<img src="/wp-content/uploads/2023/01/breadcrumbs-arrow.svg">'); ?></div>




<div class="banner-city _container"> 
	<div class="banner-cty__wrapper"> 
		<h2 class="banner-city__title">Вид на жительство в ОАЭ за покупку недвижимости от $205 000</h2>
		<div class="banner-city__row"> 
			<div class="banner-city__col"><img src="img/passport.svg" alt=""><span>ВНЖ на 3-10 лет <br> с продлением</span></div>
			<div class="banner-city__col"><img src="img/law-stamp.svg" alt=""><span> Легально для <br> граждан РФ</span></div>
		</div>
		<button class="btn-default">Запросить проекты и условия</button><img class="banner-city__pic" src="img/city-objects.svg" alt="">
	</div>
</div>

<form action="" method="post" id="main-filter-form" class="_container filter-form-search">
	<div class="main-filter">
		<div class="main-filter__value main-filter__category">
			<input class="main-filter__location" type="text" placeholder="Город, регион, страна">
			<div class="select__dropdown select__dropdown--mode">
				<div class="select__inner select__inner--mode">
					<ul class="select__results">
						<?php
						$category = get_term_by('slug', $term_slug, $taxonomy_name);

						// Создаем массив для хранения информации о категориях и количестве записей в них
						$categories_info = array();

						if ($category) {
							// Получаем все подкатегории этой категории (включая пустые)
							$subcategories = get_terms(array(
								'taxonomy' => $taxonomy_name,
								'parent' => $category->parent, // Получаем категории на том же уровне иерархии

							));

							// Если у текущей категории есть дочерние категории, добавляем их в массив
							if (!empty($subcategories)) {
								foreach ($subcategories as $subcategory) {

									// Подсчет количества записей в текущей подкатегории
									$post_count = $subcategory->count;



									$categories_info[] = array(
										'name' => $subcategory->name,
										'count' => $post_count,
										'slug' => $subcategory->slug,
									);
								}
							}

							// Если дочерних категорий нет, добавляем текущую категорию в массив
							if (empty($categories_info)) {
								$categories_info[] = array(
									'name' => $category->name,
									'count' => $category->count,
									'slug' => $category->slug,
								);
							}

							// Сортируем категории по количеству записей (от большего к меньшему)
							usort($categories_info, function ($a, $b) {
								return $b['count'] - $a['count'];
							});

							foreach ($categories_info as $category_info) {
								echo '<li class="select__type-item" data-category-slug="' . esc_html($category_info['slug']) . '"><a class="item-text" >' . esc_html($category_info['name']) . ' </a>' . $category_info['count'] . '</li>';
							}
						}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="main-filter__value main-filter__select">
			<input class="main-filter__type" placeholder="Все типы" readonly>
			<div class="select__dropdown">
				<div class="select__inner select__inner--mode">
					<ul>
						<?php
						$custom_query = new WP_Query(array(
							'post_type' => 'vse_ob_ekti',
							'posts_per_page' => -1,
						));

						if ($custom_query->have_posts()) {
							$object_types = array();

							while ($custom_query->have_posts()) {
								$custom_query->the_post();
								// Получите значение кастомного поля 'object_type' с помощью ACF
								$object_type = get_field('object_type');

								if ($object_type && isset($object_type['value']) && isset($object_type['label'])) {
									$object_types[$object_type['value']] = $object_type['label'];
								}
							}
							wp_reset_postdata();
							// Вывод начальных значений и скрытие остальных
							foreach (array_reverse($object_types) as $value => $label) {
								$is_initial_value = in_array($label, array('Таунхаусы', 'Квартиры, апартаменты', 'Дома, виллы, коттеджи'));
								$class = $is_initial_value ? '' : 'hidden no-popular';

								// Подсчет количества записей для текущего значения
								$count = array_count_values(array_column($object_types, $value));

								echo '<li class="select__type-item ' . $class . '" data-value="' . esc_attr($value) . '"><span class="item-text" style="margin-right: 10px" data-label="' . esc_attr($label) . '">' . esc_html($label) . '</span>' . $count[$value] . '</li>';
							}
							echo '<li class="show-more show-button">Показать все</li>';
							echo '<li class="hide-more show-button">Показать популярные</li>';
						}
						?>


					</ul>
				</div>

			</div>
		</div>
		<div class="main-filter__value main-filter__select main-filter__value-price">
			<div class="main-filter__price select-price">
			</div>
			<div class="select__dropdown">
				<div class="select__inner">
					<h3 class="filter-title">Цена</h3>
					<div class="select__inputs">
						<div class="select__inputs-col min">
							<label class="input" data-preholder="от">
								<input type="text" value="" >
							</label>
							<ul>
								<li data-currency="other">
									<span data-value="100000">100 тыс.</span>
								</li>
								<li data-currency="other">
									<span data-value="300000">300 тыс.</span>
								</li>
								<li data-currency="other">
									<span data-value="500000">500 тыс.</span>
								</li>
								<li data-currency="other">
									<span data-value="700000">700 тыс.</span>
								</li>
								<li data-currency="other">
									<span data-value="1000000">1 млн</span>
								</li>
								<li data-currency="other">
									<span data-value="2000000">2 млн</span>
								</li>
								<li data-currency="other">
									<span data-value="3000000">3 млн</span>
								</li>
							</ul>
						</div>
						<div class="select__inputs-col max">
							<label class="input"  data-preholder="до">
								<input type="text" value="">
							</label>
							<ul>
								<li data-currency="other">
									<span data-value="100000">100 тыс.</span>
								</li>
								<li data-currency="other">
									<span data-value="300000">300 тыс.</span>
								</li>
								<li data-currency="other">
									<span data-value="500000">500 тыс.</span>
								</li>
								<li data-currency="other">
									<span data-value="700000">700 тыс.</span>
								</li>
								<li data-currency="other">
									<span data-value="1000000">1 млн</span>
								</li>
								<li data-currency="other">
									<span data-value="2000000">2 млн</span>
								</li>
								<li data-currency="other">
									<span data-value="3000000">3 млн</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="price-cur">

					<label>
						<input type='radio' value="$" name="currency" checked class="currency_u">
						<span>$</span>
					</label>
					<label>
						<input type='radio' value="₽" name="currency" class="currency_r">
						<span>₽</span>
					</label>

				</div>
			</div>
		</div>
		<div class="main-filter__value main-filter__rooms">
			<input class="main-filter__rooms" placeholder="Спальни, ванные" readonly>
			<div class="select__dropdown">
				<div class="select__inner select__inner--mode">
					<div class="rooms">
						<p>Спальни</p>
						<div class="badrooms">
							<label>
								<input type='radio' value="1" name="badrooms" data-custom-value="badrooms-1">
								<span>1+</span>
							</label>
							<label>
								<input type='radio' value="2" name="badrooms" data-custom-value="badrooms-2">
								<span>2+</span>
							</label>
							<label>
								<input type='radio' value="3" name="badrooms" data-custom-value="badrooms-3">
								<span>3+</span>
							</label>
							<label>
								<input type='radio' value="4" name="badrooms" data-custom-value="badrooms-4">
								<span>4+</span>
							</label>
							<label>
								<input type='radio' value="" name="badrooms" checked data-custom-value="badrooms-0">
								<span>неважно</span>
							</label>
						</div>
						<p>Ванные</p>
						<div class="bashrooms">
							<label>
								<input type='radio' value="1" name="bashrooms" data-custom-value="bashrooms-1">
								<span>1+</span>
							</label>
							<label>
								<input type='radio' value="2" name="bashrooms" data-custom-value="bashrooms-2">
								<span>2+</span>
							</label>
							<label>
								<input type='radio' value="3" name="bashrooms" data-custom-value="bashrooms-3">
								<span>3+</span>
							</label>
							<label>
								<input type='radio' value="4" name="bashrooms" data-custom-value="bashrooms-4">
								<span>4+</span>
							</label>
							<label>
								<input type='radio' value="" name="bashrooms" checked data-custom-value="bashrooms-0">
								<span>неважно</span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="submit" class="btn-default main-filter__btn" value="Найти">
	</div>
</form>


<div class="single-city _container">
	<h2 class="page__title page__title--single-city"><span>Недвижимость в <?php single_cat_title(); ?></span><span>
		<?
		if ($category) {
			// Получаем все подкатегории этой категории (включая пустые)
			$subcategories = get_terms(array(
				'taxonomy' => $taxonomy_name,
				'parent' => $category->term_id,
			));

			if (!empty($subcategories) && $priceStandart === true) {
				$no_entries_found = true; // Флаг для проверки, найдены ли записи
				$queryCount = 0;
				foreach ($subcategories as $subcategory) {
					$query = subcategoriesFoundQuery($taxonomy_name, $subcategory, $categorySlug, $categoryName, $sendMaxPrice, $sendMinPrice, $sendTypeLabel, $sendTypeValue, $sendCur, $bashroomsInput, $badroomsInput);
					// Если в подкатегории есть записи, выводим ее

					if ($query->have_posts()) {
						$no_entries_found = false; // Устанавливаем флаг, что найдены записи

						$queryCount = $queryCount + intval($query->found_posts);


					}
					// Сбрасываем запрос
					wp_reset_postdata();
				}
				num_decline($queryCount, 'объявление, объявления, объявлений');
				// Если в подкатегориях нет записей
				if ($no_entries_found) {
					echo '0 объявлений';
				}
			} else {
				// Если у заданной категории нет подкатегорий
				$query = NoSubcategoriesFoundQuery($taxonomy_name, $term_slug, $categorySlug, $categoryName, $sendMaxPrice, $sendMinPrice, $sendTypeLabel, $sendTypeValue, $sendCur, $bashroomsInput, $badroomsInput);
				// Выводим заголовки найденных записей
				if ($query->have_posts()) : num_decline($query->post_count, 'объявление, объявления, объявлений');

				wp_reset_postdata(); 
				else :
				echo '0 объявлений';
				endif;

			}
		}
		?></span></h2>
	<div class="single-city__action"> 
		<div class="single-city_item"><a href=""><img src="img/map-pin.svg" alt=""><span>Смотреть на карте</span></a></div>
		<div class="single-city_item"><a href=""><img src="img/bell.svg" alt=""><span>Подписаться на обновления</span></a></div>
	</div>
</div>

<div id="filre_result">
	<?php

	if ($category) {
		// Получаем все подкатегории этой категории (включая пустые)
		$subcategories = get_terms(array(
			'taxonomy' => $taxonomy_name,
			'parent' => $category->term_id,
		));

		if (!empty($subcategories) && $priceStandart === true) {
			$no_entries_found = true; // Флаг для проверки, найдены ли записи
			echo "<section class='grid-countries _container'>";	
			foreach ($subcategories as $subcategory) {


				$query = subcategoriesFoundQuery($taxonomy_name, $subcategory, $categorySlug, $categoryName, $sendMaxPrice, $sendMinPrice, $sendTypeLabel, $sendTypeValue, $sendCur, $bashroomsInput, $badroomsInput);
				// Если в подкатегории есть записи, выводим ее
				if ($query->have_posts()) {

					$no_entries_found = false; // Устанавливаем флаг, что найдены записи
					$subcategory_info = array(
						'name' => $subcategory->name,
						'count' => $query->found_posts,
						'slug' => $subcategory->slug,
						'url' => esc_url(get_term_link($subcategory)),
					);
					$term_image = get_field('kat-pic', $subcategory);
					$subcategory_info['thumbnail'] = $term_image;

					// Вывод информации о подкатегории
					echo '<a class="grid-countries__item gc' . $gcCount . '" href="'. esc_url($subcategory_info['url']) .'" data-value="'. esc_attr($subcategory_info['slug']) .'">
                        <img class="grid-counties__pic" src="' . esc_url($subcategory_info['thumbnail']) . '" alt="' . esc_attr($subcategory_info["name"]) . '">
                        <span class="grid-countries__name">' . esc_html($subcategory_info["name"]) . '</span>
                        <span class="grid-countries__count">' . $subcategory_info['count'] . ' объявлений</span>
                    </a>';
					$gcCount++;

				}


				// Сбрасываем запрос
				wp_reset_postdata();
			}

			// Если в подкатегориях нет записей
			if ($no_entries_found) {
				echo '<div class="">К сожалению, по вашему запросу ничего не найдено.</div>';
			}
			echo "</section>";	
		} else {
			// Если у заданной категории нет подкатегорий



	?>
	<?php $query_all = NoSubcategoriesFoundQueryAll($taxonomy_name, $term_slug, $categorySlug, $categoryName, $sendMaxPrice, $sendMinPrice, $sendTypeLabel, $sendTypeValue, $sendCur, $bashroomsInput, $badroomsInput); ?>
	<?php get_template_part('template-parts/tags-block', null, ['posts' => $query_all->posts]); ?>
	<?php get_template_part('template-parts/order-block', null, null); ?>
	<?php
			echo "<div class='cards _container wrap'>
				<div class='block-content'></div>				
					<div class='cards__wrapper'>";

			$posts_per_page = 20;

			$query = NoSubcategoriesFoundQuery($taxonomy_name, $term_slug, $categorySlug, $categoryName, $sendMaxPrice, $sendMinPrice, $sendTypeLabel, $sendTypeValue, $sendCur, $bashroomsInput, $badroomsInput, $orderParam, $posts_per_page);
			// Выводим заголовки найденных записей
			$count_post = get_count_posts($taxonomy_name, $term_slug, $categorySlug, $categoryName, $sendMaxPrice, $sendMinPrice, $sendTypeLabel, $sendTypeValue, $sendCur, $bashroomsInput, $badroomsInput);
			$total_pages = ceil($count_post / $posts_per_page);
			if ($query->have_posts()) :
			while ($query->have_posts()) : $query->the_post();
			$cena = get_field('cena'); // Получаем значение поля cena
			$time_ago = human_time_diff(get_the_time('U'), current_time('timestamp')); // Получаем разницу во времени
			$images = get_field('carusel_foto');
	?>
	<div class="card"> 
		<div class="swiper swiper-card">
			<div class="swiper-wrapper"> 
				<?php foreach ($images as $image) : ?>
				<div class="swiper-slide">
					<div class="card__pics">
						<a href="<?php the_permalink(); ?>">
							<img src="<?php echo esc_url($image['link']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
						</a>
						<span class="bonus">Готовый проект</span>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
		</div>
		<div class="card__content">
			<a class="card__name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			<span class="card__price">От $<?php echo number_format($cena, 0, '', ' '); ?></span>
			<ul class="card__list">
				<li class="card__item">Построено в 2021</li>
				<li class="card__item">Всего 283 квартиры</li>
			</ul>
			<div class="card__footer">
				<span class="card__btn-gradient">Жилой комплекс</span>
				<div class="card__time">
					<img src="img/clock.svg" alt="">
					<span><?php echo $time_ago; ?> назад</span>
				</div>
			</div>
		</div> 
	</div>
	<?php
			endwhile;
			wp_reset_postdata(); 
			else :
			echo 'К сожалению, по вашему запросу ничего не найдено.';
			endif;

			echo "</div></div>";
		}
	}
	?>
	<?php get_template_part('template-parts/paginate-block', null, ['total' => $total_pages]); ?>
</div>
<?php get_template_part('/template-parts/content', 'subscription');?>
</div>
<div class="sidebar">
	<div class="sidebar sidebar-form">
		<h2 class="sidebar-form__head">Нужна консультация специалиста?</h2>
		<div class="sidebar-form__user"> <img class="sidebar-form__pic" src="/wp-content/uploads/2023/01/feedback-pic.png" alt="">
			<div class="sidebar-form__post">
				<h2 class="sidebar-form__name">Юлия Самохина</h2>
				<p class="sidebar-form__text">Менеджер по продаже недвижимости в MBR City</p>
			</div>
		</div>
		<?php echo do_shortcode('[contact-form-7 id="207" title="Менеджеры LifeEstate помогут с выбором объекта"]');?>
	</div>
	<div class="sidebar__print"> <a href=""><img src="img/printer.svg" alt=""><span>Распечатать</span></a><a href=""><img src="img/pdf.svg" alt=""><span>Скачать PDF</span></a></div>
</div>
</div>
<section class="feedback feedback--color1">
	<div class="feedback-question _container">
		<h2 class="feedback__title-mode">Индивидуальный подбор объектов</h2>
		<p class="feedback__subtitle">Оставьте заявку, наш специалист свяжется с вами для уточнения запроса и подберет подходящие объекты.</p>
		<?php echo do_shortcode('[contact-form-7 id="407" title="Индивидуальный подбор объектов"]');?>
		<div class="feedback__abs"> <img src="/wp-content/uploads/2023/01/women4.png" alt="">
			<div class="feedback__circle"> <span>Оксана Филочеева</span><span>руководитель <br>отдела продаж</span></div>
		</div>
	</div>
</section>
<?php get_template_part('template-parts/content', 'recommendation4');?>
<section class="publication _container">
	<h2 class="title-section">Публикация LifeEstate в СМИ</h2>
	<div class="publication__wrapper"> 
		<!-- 		<div class="publication__item"><img src="img/publicpic1.png" alt="">
<div class="publication__col"><span class="publication__title">ТАСС</span><a class="publication__link" href="">Эксперт считает, что заморозка недвижимости в Черногории касается только отдельных лиц</a></div>
</div>
<div class="publication__item"><img src="img/publicpic2.png" alt="">
<div class="publication__col"><span class="publication__title">ТАСС</span><a class="publication__link" href="">Эксперт считает, что заморозка недвижимости в Черногории касается только отдельных лиц</a></div>
</div>
<div class="publication__item"><img src="img/publicpic3.png" alt="">
<div class="publication__col"><span class="publication__title">Взгляд</span><a class="publication__link" href="">Определен топ стран по спросу россиян на зарубежную недвижимость</a></div>
</div>
<div class="publication__item"><img src="img/publicpic4.png" alt="">
<div class="publication__col"><span class="publication__title">Взгляд</span><a class="publication__link" href="">Определен топ стран по спросу россиян на зарубежную недвижимость</a></div>
</div>
<div class="publication__item"><img src="img/publicpic5.png" alt="">
<div class="publication__col"><span class="publication__title">РБК</span><a class="publication__link" href="">Россиянам не запретили покупать недвижимость за границей</a></div>
</div>
<div class="publication__item"><img src="img/publicpic6.png" alt="">
<div class="publication__col"><span class="publication__title">РБК</span><a class="publication__link" href="">Россиянам не запретили покупать недвижимость за границей</a></div>
</div>
<div class="publication__item"><img src="img/publicpic7.png" alt="">
<div class="publication__col"><span class="publication__title">Реальное время</span><a class="publication__link" href="">Татарстан вошел в топ-10 регионов России по спросу на зарубежную недвижимость</a></div>
</div>
<div class="publication__item"><img src="img/publicpic8.png" alt="">
<div class="publication__col"><span class="publication__title">Реальное время</span><a class="publication__link" href="">Татарстан вошел в топ-10 регионов России по спросу на зарубежную недвижимость</a></div>
</div> -->
		<?php
		// проверяем есть ли в повторителе данные
		if( have_rows('publications') ):
		// перебираем данные
		while ( have_rows('publications') ) : the_row();
		?>		
		<div class="publication__item">
			<?php the_sub_field('logo'); ?>
			<div class="publication__col">
				<span class="publication__title"><?php the_sub_field('title');?></span>
				<a class="publication__link" href=""><?php the_sub_field('text');?></a>
			</div>
			<?php	endwhile;
			else :
			// вложенных полей не найдено
			endif;
			?>
		</div>
	</div>
</section>
<section class="team _container"> 
	<h2 class="title-section">Команда LifeEstate</h2>
	<div class="team__wrapper"> 
		<div class="team__item">
			<div class="team__pic"> <img src="/wp-content/uploads/2023/01/teamuser1.jpg" alt=""></div><span class="team__name"> </span><span class="team__descr"> </span>
		</div>
		<div class="team__item">
			<div class="team__pic"> <img src="/wp-content/uploads/2023/01/teamuser2.jpg" alt=""></div><span class="team__name"> </span><span class="team__descr"> </span>
		</div>
		<div class="team__item">
			<div class="team__pic team__pic--mode"><span>Вся команда LifeEstate</span></div><span class="team__name"> </span><span class="team__descr"> </span>
		</div>
	</div>
</section>
<section class="feedback feedback--color1">
	<div class="feedback-large _container">
		<div class="feedback-large__col feedback-large__descr"><img class="feedback__avatar"
																	src="/wp-content/uploads/2023/01/feedback-pic.png" alt=""><span>Марина Филичкина</span><span>Директор по продажам</span><a
              href="">8 (800) 333 10 85</a></div>
		<div class="feedback-large__col">
			<h2 class="feedback__title">Менеджеры LifeEstate помогут с выбором объекта</h2>
			<!-- 							<form class="feedback-form" action="">
<div class="feedback-form__row">
<textarea placeholder="Например, квартира за рубежом"></textarea>
</div>
<div class="feedback-form__row">
<input type="text" placeholder="Имя">
</div>
<div class="feedback-form__row">
<input type="phone" placeholder="Телефон">
</div>
<div class="feedback-form__row">
<input type="email" placeholder="Email">
</div>
<button class="btn-default" type="submit">Оставить заявку</button><span class="feedback__assent">Я
согласен с <a href="">правилами обработки персональных данных и политикой конфиденциальности
LifeEstate</a></span>
</form> -->
			<?php echo do_shortcode('[contact-form-7 id="207" title="Менеджеры LifeEstate помогут с выбором объекта"]')?>
		</div>
		<div class="feedback-large__col">
			<ul class="feedback__list">
				<li><img src="/wp-content/uploads/2023/01/adv1.svg" alt=""><span>Работаем без комиссии</span></li>
				<li><img src="/wp-content/uploads/2023/01/adv2.svg" alt=""><span>Полное сопровождение сделки</span></li>
				<li><img src="/wp-content/uploads/2023/01/adv3.svg" alt=""><span>Кэшбэк до 1% от сделки</span></li>
			</ul>
		</div>
	</div>
</section>
<?php get_template_part('template-parts/content', 'countries');?>

<?php get_footer();?>
