$(function($){
    $('#map-brazil').cssMap({'size' : 340,loadingText : 'Carregando mapa...'});
    

    $('#map-brazil li').on('click', function(){
		var uf = $(this).attr('class').split(' ')[0];
		
		switch(uf)
		{
			case "br1":
			  $('#estado option[value=AC]').attr('selected', 'selected');
			  break;

			case "br2":
			  $('#estado option[value=AL]').attr('selected', 'selected');
			  break;

			case "br3":
			  $('#estado option[value=AP]').attr('selected', 'selected');
			  break;

			case "br4":
			  $('#estado option[value=AM]').attr('selected', 'selected');
			  break;

			case "br5":
			  $('#estado option[value=BA]').attr('selected', 'selected');
			  break;
			
			case "br6":
			  $('#estado option[value=CE]').attr('selected', 'selected');
			  break;

			case "br7":
			  $('#estado option[value=DF]').attr('selected', 'selected');
			  break;

			case "br8":
			  $('#estado option[value=ES]').attr('selected', 'selected');
			  break;

			case "br9":
			  $('#estado option[value=GO]').attr('selected', 'selected');
			  break;
			
			case "br10":
			  $('#estado option[value=MA]').attr('selected', 'selected');
			  break;

			case "br11":
			  $('#estado option[value=MT]').attr('selected', 'selected');
			  break;

			case "br12":
			  $('#estado option[value=MS]').attr('selected', 'selected');
			  break;
			
			case "br13":
			  $('#estado option[value=MG]').attr('selected', 'selected');
			  break;
			
			case "br14":
			  $('#estado option[value=PA]').attr('selected', 'selected');
			  break;

			case "br15":
			  $('#estado option[value=PB]').attr('selected', 'selected');
			  break;

			case "br16":
			  $('#estado option[value=PR]').attr('selected', 'selected');
			  break;  

			case "br17":
			  $('#estado option[value=PE]').attr('selected', 'selected');
			  break;
			
			case "br18":
			  $('#estado option[value=PI]').attr('selected', 'selected');
			  break;

			case "br19":
			  $('#estado option[value=RJ]').attr('selected', 'selected');
			  break;

			case "br20":
			  $('#estado option[value=RN]').attr('selected', 'selected');
			  break;

			case "br21":
			  $('#estado option[value=RS]').attr('selected', 'selected');
			  break;
			
			case "br22":
			  $('#estado option[value=RO]').attr('selected', 'selected');
			  break;

			case "br23":
			  $('#estado option[value=RR]').attr('selected', 'selected');
			  break;

			case "br24":
			  $('#estado option[value=SC]').attr('selected', 'selected');
			  break;

			case "br25":
			  $('#estado option[value=SP]').attr('selected', 'selected');
			  break;
			
			case "br26":
			  $('#estado option[value=SE]').attr('selected', 'selected');
			  break;

			case "br27":
			  $('#estado option[value=TO]').attr('selected', 'selected');
			  break;
    
			
		}	
		buscaEstado();
		//populaCidades();
	}); 
});


  function populaUnidades(data, displayCity)
  {
	
	var cityDivs = [];
	var infoDivs = [];
	var city_html = '';
	i = 0;
	$.each( data, function( key, cities ) {

	$.each(cities, function (city, objs) 
	    {
	    	i++;
	    	
	    	city_html = '';
	    	$.each(objs, function (key, city_info)
	    	{
	    		
	    		city_html += '<dt>' + key + '</dt>';	

	    		phone1 = '';
	    		if (city_info.phone1 != null)
	    			phone1 = city_info.phone1;

	    		phone2 = '';
	    		if (city_info.phone2 != null)
	    			phone2 = ' / ' + city_info.phone2;
	    		console.log(city_info);
	    		city_html += '<dd class="endereco">' + city_info.address + '</dd>';
	    		city_html += '<dd class="fones">' + phone1 + phone2 + '</dd>';
	    		city_html += '<dd class="email"><a href="mailto:' + city_info.email + '">' + city_info.email + '</a></dd>';
	    		if (!city_info.status) city_html += 'Inauguração em breve';
				
	    	});
			
	    	cityDivs.push('<h5><a href="javascript:void(0)" onclick="$(\'#city_' + i + '\').slideToggle();">' + city + "</a></h5>");
	    	if (displayCity == 1)
	    		displayDiv = 'block';
	    	else
	    		displayDiv = 'none';
	    	cityDivs.push('<div class="lista" id="city_' + i + '" style="display:' + displayDiv + '"><dl>' + city_html + '</dl></div>');		    }
	);
	});

	$("#unidadesResultado").show();
	

	$('#unidadesResultado').empty();
	$('#unidadesResultado').append('<h4>' + $('#estado option[value=' + uf + ']').text() + '</h4>');
	$('#unidadesResultado').append(cityDivs);
	$('body').scrollTo('#unidadesResultado');
  	//console.log(items);
  }
  function buscaEstado()
  {
  	$("#nocity").hide();
  	$('#unidadesResultado').empty();
  	$("#cidades").hide();
  	$('#div_carregando').show();
  	var cityOptions = [];
  	//console.log($("div_carregando"));
  	uf = $("#estado").val();

	$('.active-region').removeClass('active-region');
  	switch(uf)
	{
		case "AC":
		  $('.br1').addClass('active-region');
		  break;
		
		case "AL":
		  $('.br2').addClass('active-region');
		  break;

		case "AP":
		  $('.br3').addClass('active-region');
		  break;

		case "AM":
		  $('.br4').addClass('active-region');
		  break;

		case "BA":
		  $('.br5').addClass('active-region');
		  break;
		
		case "CE":
		  $('.br6').addClass('active-region');
		  break;

		case "DF":
		  $('.br7').addClass('active-region');
		  break;

		case "ES":
		  $('.br8').addClass('active-region');
		  break;

		case "GO":
		  $('.br9').addClass('active-region');
		  break;
		
		case "MA":
		  $('.br10').addClass('active-region');
		  break;

		case "MT":
		  $('.br11').addClass('active-region');
		  break;

		case "MS":
		  $('.br12').addClass('active-region');
		  break;
		
		case "MG":
		  $('.br13').addClass('active-region');
		  break;
		
		case "PA":
		  $('.br14').addClass('active-region');
		  break;

		case "PB":
		  $('.br15').addClass('active-region');
		  break;

		case "PR":
		  $('.br16').addClass('active-region');
		  break;  

		case "PE":
		  $('.br17').addClass('active-region');
		  break;
		
		case "PI":
		  $('.br18').addClass('active-region');
		  break;

		case "RJ":
		  $('.br19').addClass('active-region');
		  break;

		case "RN":
		  $('.b20').addClass('active-region');
		  break;

		case "RS":
		  $('.br21').addClass('active-region');
		  break;
		
		case "RO":
		  $('.br22').addClass('active-region');
		  break;

		case "RR":
		  $('.br23').addClass('active-region');
		  break;

		case "SC":
		  $('.br24').addClass('active-region');
		  break;

		case "SP":
		  $('.br25').addClass('active-region');
		  break;
		
		case "SE":
		  $('.br26').addClass('active-region');
		  break;

		case "TO":
		  $('.br27').addClass('active-region');
		  break;
    
	}

	$.getJSON( "/app_dev.php/buscaUnidade/" + uf, function( data ) {
		if (!Array.isArray(data.units))
		{
			
			if (Object.keys(data.units).length == 1) 
				populaUnidades(data, 1);
			else
				populaUnidades(data);
			$.each( data, function( key, cities ) {
		  		
		  		cityOptions.push( "<option value=''>Selecione uma cidade</option>" );
				$.each(cities, function (city, objs) 
				{
					cityOptions.push( "<option value='" + city + "'>" + city + "</option>" );
				}
				);
			});
			
			$('#cidades').find('option').remove().end().append(cityOptions);
			$('#cidades').show();
		}
		else
		{
			$("#nocity").show();
		}
		$('#div_carregando').hide();
	});

	//populaCidades();
  }
  function buscaCidade()
  {
  	$("#nocity").hide();
  	$('#div_carregando').show();
  	//console.log($("div_carregando"));
  	uf = $("#estado").val();
  	city = $("#cidades").val();

	$.getJSON( "/app_dev.php/buscaUnidade/" + uf + "/" + city, function( data ) {
		populaUnidades(data, 1);
		$('#div_carregando').hide();
		$("#cidades").val(city);

	});
  	

  }