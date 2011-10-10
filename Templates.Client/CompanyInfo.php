<style>
	#company-info #address {
		padding: 10px 0;
	}
	
	#company-info #address a {
		font-size: 18px;
	}
	
	#company-info #address a:hover {
		border-bottom: 2px dashed #6e0202;
		text-decoration: none;
	}
	
	#company-info .map {
		width: auto;
		height:	500px;
		border: 1px solid #940505;
	}
	
	#company-info #info {
		margin: 20px;
		border-left: 5px solid #cdcdcd;
		padding-left: 40px;
	}
</style>
<div id="company-info">
	<script>
		var wholesaleMap = null;
		var retailMap = null;
		var kuibyshevMap = null;
		function showWholesaleMap() {
			$('#map-wholesale').show();
			$('#map-retail').hide();
			$('#map-kuibyshev').hide();
			wholesaleMap.redraw();
			return false;
		}
		function showRetailMap() {
			$('#map-wholesale').hide();
			$('#map-retail').show();
			$('#map-kuibyshev').hide();
			retailMap.redraw();
			return false;
		}
		function showKuibyshevMap() {
			$('#map-wholesale').hide();
			$('#map-retail').hide();
			$('#map-kuibyshev').show();
			kuibyshevMap.redraw();
			return false;
		}
		$(function() {
			showWholesaleMap();
		});
	</script>
	<div id="address">
		<a href="#" onclick="return showWholesaleMap();">Оптовый магазин</a>&emsp;|&emsp;
		<a href="#" onclick="return showRetailMap();">Розничный магазин</a>&emsp;|&emsp;
		<a href="#" onclick="return showKuibyshevMap();">Филиал в г.Куйбышев</a>
	</div>
	
	<!-- Wholesale map -->
	<div id="map-wholesale">
		<script src="http://api-maps.yandex.ru/1.1/?key=AJRP_k0BAAAAyk-kUwQACLkBXcJyAfBYvhl4JB_e79PNY3IAAAAAAAAAAAAoWIQf1hkE80Ndfcia1YqB5WaCLw==&modules=pmap&wizard=constructor" type="text/javascript"></script>
		<script type="text/javascript">
			YMaps.jQuery(window).load(function () {
				wholesaleMap = new YMaps.Map(YMaps.jQuery("#YMapsIDWholesale")[0]);
				wholesaleMap.setCenter(new YMaps.GeoPoint(83.000429,55.051786), 14, YMaps.MapType.MAP);
				wholesaleMap.addControl(new YMaps.Zoom());
				wholesaleMap.addControl(new YMaps.ToolBar());
				wholesaleMap.addControl(new YMaps.TypeControl());
				YMaps.Styles.add("constructor#pmrdlPlacemark", {
					iconStyle : {
						href : "http://api-maps.yandex.ru/i/0.3/placemarks/pmrdl.png",
						size : new YMaps.Point(36,41),
						offset: new YMaps.Point(-13,-40)
					}
				});

				wholesaleMap.addOverlay(createObject("Placemark", new YMaps.GeoPoint(83.000021,55.051663), "constructor#pmrdlPlacemark", "Мир Рыбалки Охоты и Туризма, оптовый склад"));
				function createObject (type, point, style, description) {
					var allowObjects = ["Placemark", "Polyline", "Polygon"],
						index = YMaps.jQuery.inArray( type, allowObjects),
						constructor = allowObjects[(index == -1) ? 0 : index];
						description = description || "";
					var object = new YMaps[constructor](point, {style: style, hasBalloon : !!description});
					object.description = description;
					return object;
				}
			});
		</script>
		<div id="YMapsIDWholesale" class="map"></div>
				<?php
			foreach ($wholesaleAddress as $address) {
				echo $address['content'];
			}
		?>
	</div>
	
	<!-- Retail map -->
	<div id="map-retail">
		<script src="http://api-maps.yandex.ru/1.1/?key=AJRP_k0BAAAAyk-kUwQACLkBXcJyAfBYvhl4JB_e79PNY3IAAAAAAAAAAAAoWIQf1hkE80Ndfcia1YqB5WaCLw==&modules=pmap&wizard=constructor" type="text/javascript"></script>
		<script type="text/javascript">
			YMaps.jQuery(window).load(function () {
				retailMap = new YMaps.Map(YMaps.jQuery("#YMapsIDRetail")[0]);
				retailMap.setCenter(new YMaps.GeoPoint(82.894518,54.97934), 14, YMaps.MapType.MAP);
				retailMap.addControl(new YMaps.Zoom());
				retailMap.addControl(new YMaps.ToolBar());
				retailMap.addControl(new YMaps.TypeControl());
				YMaps.Styles.add("constructor#pmrdlPlacemark", {
					iconStyle : {
						href : "http://api-maps.yandex.ru/i/0.3/placemarks/pmrdl.png",
						size : new YMaps.Point(36,41),
						offset: new YMaps.Point(-13,-40)
					}
				});

				retailMap.addOverlay(createObject("Placemark", new YMaps.GeoPoint(82.894518,54.97934), "constructor#pmrdlPlacemark", "Мир Рыбалки Охоты и Туризма, розничный магазин"));
				function createObject (type, point, style, description) {
					var allowObjects = ["Placemark", "Polyline", "Polygon"],
						index = YMaps.jQuery.inArray( type, allowObjects),
						constructor = allowObjects[(index == -1) ? 0 : index];
						description = description || "";
					var object = new YMaps[constructor](point, {style: style, hasBalloon : !!description});
					object.description = description;
					return object;
				}
			});
		</script>
		<div id="YMapsIDRetail" class="map"></div>
		<?php
			foreach ($retailAddress as $address) {
				echo $address['content'];
			}
		?>
	</div>
	
	<!-- Kuibyshev map -->
	<div id="map-kuibyshev">
		<script src="http://api-maps.yandex.ru/1.1/?key=AJRP_k0BAAAAyk-kUwQACLkBXcJyAfBYvhl4JB_e79PNY3IAAAAAAAAAAAAoWIQf1hkE80Ndfcia1YqB5WaCLw==&modules=pmap&wizard=constructor" type="text/javascript"></script>
		<script type="text/javascript">
			YMaps.jQuery(window).load(function () {
				kuibyshevMap = new YMaps.Map(YMaps.jQuery("#YMapsIDKuibyshev")[0]);
				kuibyshevMap.setCenter(new YMaps.GeoPoint(78.291235,55.47197), 11, YMaps.MapType.MAP);
				kuibyshevMap.addControl(new YMaps.Zoom());
				kuibyshevMap.addControl(new YMaps.ToolBar());
				kuibyshevMap.addControl(new YMaps.TypeControl());
				YMaps.Styles.add("constructor#pmrdlPlacemark", {
					iconStyle : {
						href : "http://api-maps.yandex.ru/i/0.3/placemarks/pmrdl.png",
						size : new YMaps.Point(36,41),
						offset: new YMaps.Point(-13,-40)
					}
				});

				kuibyshevMap.addOverlay(createObject("Placemark", new YMaps.GeoPoint(78.310462,55.457926), "constructor#pmrdlPlacemark", "Мир Рыбалки Охоты и Туризма, филиал в г.Куйбышев"));
				function createObject (type, point, style, description) {
					var allowObjects = ["Placemark", "Polyline", "Polygon"],
						index = YMaps.jQuery.inArray( type, allowObjects),
						constructor = allowObjects[(index == -1) ? 0 : index];
						description = description || "";
					var object = new YMaps[constructor](point, {style: style, hasBalloon : !!description});
					object.description = description;
					return object;
				}
			});
		</script>
		<div id="YMapsIDKuibyshev" class="map"></div>
		<?php
			foreach ($kuibyshevAddress as $address) {
				echo $address['content'];
			}
		?>
	</div>
	
	<div id="info">
		<?php
			foreach ($companyInfo as $info) {
				echo $info['content'];
			}
		?>
	</div>
</div>