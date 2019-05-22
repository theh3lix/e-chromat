var cnt = 0;
var nowShowed = 1;
var server = "subsites/server.php";

function remmail(){
$("#login").html(`
  <h4>Podaj swój adres e-mail</h4>
  <form method="post" action="subsites/server.php">
  <input id="mailtoremember" type="email" class="input" placeholder="username@email.com" name="mailtoremember" />
  <button class="btn" type="submit" style="clear: both;" name="remember_mail">Dalej</button>
  </form>
  `); return false;
}

function onLd() {
  document.getElementById('navbar2').classList.remove('is-active');
  $('.active').removeClass("active");
  $('#main').html(`
    <div class="product" style="overflow: visible; padding: 0; max-height: none; text-align: center; max-width: 90%; background: none; box-shadow: none;">${trendingAr.map(trendingTemplate).join("")};</div>
    `);
  $('.error').addClass("fout");
  $('.error').one("transitionend",
              function(event) {
                $('.error').attr({style: 'display: none;'});
  });
  document.getElementById("ldscreen").style.display = "none";
}

function ldScr(txt) {
  $('<div/>').attr({
    id: 'ldscreen',
  }).html(`<h4 style="font-family: 'Oswald', sans-serif; margin-top: 10px; margin-left: auto; margin-right: auto;">Proszę czekać</h4><br>`).appendTo('#main');
  $('<div/>').attr({
    class: 'loader',
  }).appendTo('#ldscreen');
}

const kubkiAr = [
  {
    id: 1,
    name: "Kubek Biały",
    species: "kubek",
    material: "Ceramika",
    colours: ["Biały"],
    photo: "/e-chromat/imagess/produkty/k1.png",
    price: 17.9,
    desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
  },
  {
    id: 2,
    name: "Kolorowe Wnętrze",
    species: "kubek",
    material: "Ceramika",
    colours: ["Zielony", "Niebieski", "Fioletowy", "Czarny", "Pomarańczowy", "Błękitny", "Czerwony"],
    photo: "/e-chromat/imagess/produkty/k2.png",
    price: 18.9,
    desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
  },
  {
    id: 3,
    name: "Kubek Magiczny",
    species: "kubek",
    material: "Ceramika",
    colours: ["Błękitny", "Czerwony", "Niebieski", "Czarny"],
    photo: "/e-chromat/imagess/produkty/k3.png",
    price: 27,
    desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
  },
  {
    id: 4,
    name: "Kubek Latte",
    species: "kubek",
    material: "Ceramika",
    colours: ["Biały"],
    photo: "/e-chromat/imagess/produkty/k4.png",
    price: 19.9,
    desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
  },
  {
    id: 5,
    name: "Kubek Latte duży",
    species: "kubek",
    material: "Ceramika",
    colours: ["Biały"],
    photo: "/e-chromat/imagess/produkty/k5.png",
    price: 23.9,
    desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
  },
  {
    id: 6,
    name: "Kubek Mini",
    species: "kubek",
    material: "Ceramika",
    colours: ["Biały"],
    photo: "/e-chromat/imagess/produkty/k6.png",
    price: 15.9,
    desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
  },
  {
    id: 7,
    name: "Kubek z łyżeczką",
    species: "kubek",
    material: "Ceramika",
    colours: ["Zielony", "Czerwony", "Różowy", "Żółty", "Niebieski"],
    photo: "/e-chromat/imagess/produkty/k7.png",
    price: 20.9,
    desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
  },
  {
    id: 8,
    name: "Kubek Szroniony",
    species: "kubek",
    material: "Ceramika",
    colours: ["Biały"],
    photo: "/e-chromat/imagess/produkty/k8.png",
    price: 31.9,
    desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
  },
  {
    id: 9,
    name: "Kufel Biały",
    species: "kubek",
    material: "Ceramika",
    colours: ["Biały"],
    photo: "/e-chromat/imagess/produkty/k9.png",
    price: 45,
    desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
  }
];
const poduszkiAr = [
    {
        id: 10,
        name: "Poduszka 40x40",
        species: "tekstylia",
        material: "Mikrofibra",
        photo: "/e-chromat/imagess/produkty/p1.png",
        price: 26.9,
        desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
    },
    {
        id: 11,
        name: "Poduszka Serce",
        species: "tekstylia",
        material: "Mikrofibra",
        photo: "/e-chromat/imagess/produkty/p2.png",
        price: 31.9,
        desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
    },
    {
        id: 12,
        name: "Śliniak",
        species: "tekstylia",
        material: "Włókno bambusowe",
        photo: "/e-chromat/imagess/produkty/p3.png",
        price: 13.5,
        desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
    }
];


const tekstyliaAr = [
    {
        id: 13,
        name: "Torba Mała",
        species: "tekstylia",
        material: "Bawełna",
        photo: "/e-chromat/imagess/produkty/t1.png",
        price: 40,
        desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
    },
    {
        id: 14,
        name: "Fartuch",
        species: "tekstylia",
        material: "Tworzywo sztuczne",
        photo: "/e-chromat/imagess/produkty/t2.png",
        price: 25.9,
        desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
    },
    {
        id: 15,
        name: "Koszulka",
        species: "tekstylia",
        material: "Bawełna",
        photo: "/e-chromat/imagess/produkty/t3.png",
        price: 25,
        desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
    }
];

const trendingAr = [
  {
      id: 16,
      name: "Koszulka",
      species: "tekstylia",
      material: "Bawełna",
      photo: "/e-chromat/imagess/produkty/t3.png",
      price: 25,
      desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
  },
  {
      id: 17,
      name: "Poduszka 40x40",
      species: "tekstylia",
      material: "Mikrofibra",
      photo: "/e-chromat/imagess/produkty/p1.png",
      price: 26.9,
      desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
  },
  {
      id: 18,
      name: "Torba Mała",
      species: "tekstylia",
      material: "Bawełna",
      photo: "/e-chromat/imagess/produkty/t1.png",
      price: 40,
      desc: "Kubek ceramiczny o pojemności około 300ml, pokryty wysokiej jakości powłoką przeznaczoną do sublimacji. Kubek można bepziecznie myć w zmywarce, a jego odporność przetestowana przez producenta to aż 3000 cykli!"
  }
];

const dzienMatkiAr = [
  {
      category: 'dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama1.jpg"
  },
  {
      category: 'dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama2.jpg"
  },
  {
      category: 'dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama3.jpg"
  },
  {
      category: 'dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama4.jpg"
  },
  {
      category: 'dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama5.jpg"
  },
  {
      category: 'dzienojca dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama6.jpg"
  },
  {
      category: 'dzienojca dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama7.jpg"
  },
  {
      category: 'dzienojca dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama8.jpg"
  },
  {
      category: 'dzienojca dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama9.jpg"
  },
  {
      category: 'dzienojca dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama10.jpg"
  },
  {
      category: 'dzienbabci dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama11.jpg"
  },
  {
      category: 'dzienbabci dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama12.jpg"
  },
  {
      category: 'dzienbabci dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama13.jpg"
  },
  {
      category: 'dzienbabci dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama14.jpg"
  },
  {
      category: 'dzienbabci dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama15.jpg"
  },
  {
      category: 'dziendziadka dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama16.jpg"
  },
  {
      category: 'dziendziadka dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama17.jpg"
  },
  {
      category: 'dziendziadka dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama18.jpg"
  },
  {
      category: 'dziendziadka dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama19.jpg"
  },
  {
      category: 'dziendziadka dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama20.jpg"
  },
  {
      category: 'urodziny dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama21.jpg"
  },
  {
      category: 'urodziny dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama22.jpg"
  },
  {
      category: 'urodziny dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama23.jpg"
  },
  {
      category: 'urodziny dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama24.jpg"
  },
  {
      category: 'urodziny dzienmamy',
      src: "/e-chromat/imagess/produkty/dzien_matki/kubmama25.jpg"
  }
];


function kolor(kolory) {
  return `
<h4 style="float: left;padding-right: 10px; margin-top: 7px;">Kolor: \t</h4> <select name="kolory" class="foods-list input" style="height: 35px;margin-bottom: 10px; margin-top: 4px;">
${kolory.map(kolor => `<option value="${kolor}">${kolor}</option>`).join("")}
</select>
`;
}

function productTemplate(product) {
  return `
    <div class="product">
        <form method="post" action=${server} enctype="multipart/form-data">
            <img class="product-photo" src="${product.photo}">
            <h2 class="product-name">${product.name}</h2>
            <h4>Materiał: ${product.material}</h4>
            ${product.colours ? kolor(product.colours) : ""} <br>
            <h4 style="display: inline-block;">Grafika: \t</h4> <input type="file" style="display: inline-block;" id="${product.name}" name="upload_file" required></input>
            <input type="submit" onclick="return ret('${product.name}');" value="Zamów" name="${product.species}" class="zamow"/>
            <textarea rows="3" style="font-size: 12px; clear: both; margin-top: 10px;" cols="40" name="komentarz" placeholder="Komentarz do zamówienia"></textarea>
            <input type="hidden" name="prodname" value="${product.name}" />
            <input type="hidden" name="material" value="${product.material}" />
            <input type="hidden" name="cena" value="${product.price}" />
            <input type="hidden" name="foto" value="${product.photo}" />
        </form>
    </div>
  `;
}

function graphicTemplate(graphics, productid) {
  return `<div class="graphic ${graphics.category}"><img src="${graphics.src}" onclick="$('.graphic img').removeClass('selected');
                                                                                $(this).addClass('selected');
                                                                                $('#btn${productid}').css('backgroundColor', 'white');
                                                                                $('#btn${productid}').css('boxShadow', '0 0 7px 2px rgba(0,255,0,0.6)');
                                                                                $('#${productid}').css('display', 'none');
                                                                                $('#${productid}-foto').attr({value: '${graphics.src}'});"/></div>`;
}


function trendingTemplate(product) {
  return `
    <div class="product trending col-xs-12 col-md-6">
        <form method="post" action=${server} enctype="multipart/form-data">
            <img class="product-photo" src="${product.photo}">
            <h2 class="product-name" style="float: left;">${product.name}</h2><br><br>
            <button class="wybierz" id="btn${product.id}" onclick="document.getElementById('${product.id}').style.display='block'; return false;">Wybierz grafikę</button>
            <h4>Materiał: ${product.material}</h4>
            ${product.colours ? kolor(product.colours) : ""} <br><br>
            <p style="clear: both;
              left: 10px;
              bottom: 10px;
              font-size: 12px;
              background-color: white;
              border-radius: 3px;
              padding: 5px;
              margin-top: 10px;
              width: 60%;">${product.desc}</p>
            <input type="submit" onclick="return ret('${product.name}');" value="Zamów" name="${product.species}" class="zamow"/>
            <div class="graphic_choice" style="display: none;" id="${product.id}">
              <button type="button" onclick="document.getElementById('${product.id}').style.display='none'; return false;" class="close" aria-label="Close">
                  <span aria-hidden="true" style="opacity: 0;">&times;</span>
              </button>
              <div class="left_menu">
                <br><br><br>
                <a class="dzien_mamy" onclick="
                  $('.graphic').css('display', 'none');
                  $('.dzienmamy').css('display', 'inline-block');
                  $('.left_menu a').removeClass('active');
                  $(this).addClass('active');
                ">DZIEŃ MAMY</a><br>
                <a class="dzien_ojca" onclick="
                  $('.graphic').css('display', 'none');
                  $('.dzienojca').css('display', 'inline-block');
                  $('.left_menu a').removeClass('active');
                  $(this).addClass('active');
                ">DZIEŃ OJCA</a><br>
                <a class="dzien_babci" onclick="
                  $('.graphic').css('display', 'none');
                  $('.dzienbabci').css('display', 'inline-block');
                  $('.left_menu a').removeClass('active');
                  $(this).addClass('active');
                ">DZIEŃ BABCI</a><br>
                <a class="dzien_dziadka" onclick="
                  $('.graphic').css('display', 'none');
                  $('.dziendziadka').css('display', 'inline-block');
                  $('.left_menu a').removeClass('active');
                  $(this).addClass('active');
                ">DZIEŃ DZIADKA</a><br>
                <a class="urodziny" onclick="
                  $('.graphic').css('display', 'none');
                  $('.urodziny').css('display', 'inline-block');
                  $('.left_menu a').removeClass('active');
                  $(this).addClass('active');
                ">URODZINY</a><br>
              </div>
              <div class="right_content" id="inmain">
                ${dzienMatkiAr.map(function(x) {return graphicTemplate(x,product.id);}).join("")}
              </div>
            </div>
            <input type="hidden" name="prodname" value="${product.name}" />
            <input type="hidden" name="material" value="${product.material}" />
            <input type="hidden" name="cena" value="${product.price}" />
            <input type="hidden" id="${product.id}-foto" name="foto" value=""/>
        </form>
    </div>
  `;
}


$(document).ready(function(){
    $(".tekstylia").click(function(){
        document.getElementById('navbar2').classList.remove('is-active');
        document.getElementById("main").innerHTML = `
        <div class="product" style="overflow: visible; padding: 0; max-height: none; text-align: center; max-width: 90%; background: none; box-shadow: none;">
        ${tekstyliaAr.map(trendingTemplate).join("")};</div>`;
        $('.active').removeClass("active");
        $('.tekstylia').addClass("active");
    });

    $(".kubki").click(function(){
        document.getElementById('navbar2').classList.remove('is-active');
        document.getElementById("main").innerHTML = `
        <div class="product" style="overflow: visible; padding: 0; max-height: none; text-align: center; max-width: 90%; background: none; box-shadow: none;">
        ${kubkiAr.map(trendingTemplate).join("")};</div>`;
        $('.active').removeClass("active");
        $('.kubki').addClass("active");
    });

    $(".poduszki").click(function(){
        document.getElementById('navbar2').classList.remove('is-active');
        document.getElementById("main").innerHTML = `
        <div class="product" style="overflow: visible; padding: 0; max-height: none; text-align: center; max-width: 90%; background: none; box-shadow: none;">
        ${poduszkiAr.map(trendingTemplate).join("")};</div>`;
        $('.active').removeClass("active");
        $('.poduszki').addClass("active");
    });

    $(".wydruki").click(function(){
        document.getElementById('navbar2').classList.remove('is-active');
        $('#main').html(`<div class="product hdr" style="max-width: 500px;">
    <form method="post" action=${server} id="form" enctype="multipart/form-data">
        <h2 class="product-name head-name">Wybierz pliki</h2>
        <input type=\'file\' id=\'wydrukiIn\' onchange="imgToData(this);" style=\"overflow: hidden; display: block; margin-bottom: 10px;\" name="upload_file[]" multiple required></input>\n\
        <select class=\'select input\' name=\'rozmiar\' id=\'selectplotna\'>\n\
            <option value=\'20x30\'>20x30</option>\n\
            <option value=\'30x42\'>30x42</option>\n\
            <option value=\'40x50\'>40x50</option>\n\
            <option value=\'40x60\'>40x60</option>\n\
            <option value=\'50x70\'>50x70</option>\n\
            <option value=\'60x90\'>60x90</option>\n\
            <option value=\'70x100\'>70x100</option>\n\
            <option value=\'100x150\'>100x150</option>\n\
            <option value=\'100x200\'>100x200</option>\n\
        </select>\n\
        <textarea rows="3" style="display: block; font-size: 10px; clear: both; margin-top: 7px;" cols="40" name="komentarz" placeholder="Komentarz do zamówienia"></textarea>
        <input type=\'submit\' onclick="return ret('wydrukiIn');" id=\'submitplotna\' class=\'zamow\' name=\'plotna\' value=\'Wyślij\'/> <br>\n\
    </form>
    <button id='podglad' style='float: right;' class='zamow' onclick="
        if(document.getElementById('gallery').style.display=='none'){
            document.getElementById('podglad').style.backgroundColor='white';
            document.getElementById('podglad').style.boxShadow='0 0 5px 3px rgba(0,255,0,0.6)';
            document.getElementById('gallery').style.display='block';
            document.getElementById('img-'+nowShowed+'-preview').style.display='block';
        } else {
            document.getElementById('gallery').style.display='none';
            document.getElementById('podglad').style.backgroundColor='#ddd';
            document.getElementById('podglad').style.boxShadow='0 0 5px 2px rgba(0,0,0,0.6)';
        } return false;">Podgląd</button>
    </div>
    <div class="product hdr" style="height: 300px; max-width: 850px; display: none; overflow: visible; padding: 0;" id="gallery"></div>
`);
        $('.active').removeClass("active");
        $('.wydruki').addClass("active");
    });



    $(".odbitki").click(function(){
        document.getElementById('navbar2').classList.remove('is-active');
        $('#main').html(`<form method="post" action=${server} id="form" enctype="multipart/form-data">
		<div class="product hdr" style="max-width: 500px;">
                <h2 class="product-name head-name">Wybierz pliki</h2>
                <input type=\'file\' id=\'odbitkiIn\' onchange="imgToData(this);" style=\"overflow: hidden; display: block; margin-bottom: 10px;\" name="upload_file[]" multiple required></input>\n\
                <select class=\'select input\' name=\'rozmiar\' id=\'selectodbitki\'>\'\n\
                    <option value=\'9x13\'>9x13</option>\n\
                    <option value=\'10x15\'>10x15</option>\n\
                    <option value=\'13x18\'>13x18</option>\n\
                    <option value=\'15x21\'>15x21</option>\n\
                    <option value=\'20x30\'>20x30</option>\n\
                </select>\n\<br>
                <select class=\'select input\' name=\'wypelnienie\' id=\'selectwypelnienie\'>\'\n\
                    <option value=\'przytnij\'>Przytnij</option>\n\
                    <option value=\'dopasuj\'>Dopasuj</option>\n\
                </select>\n\<br>
                <select class=\'select input\' name=\'powierzchnia\' id=\'selectpowierzchnia\'>\'\n\
                    <option value=\'mat\'>Mat</option>\n\
                    <option value=\'błysk\'>Błysk</option>\n\
                </select>\n\<br>
                <select class=\'select input\' name=\'sepia\' id=\'selectsepia\'>'\n\
                  <option value=\'Domyślne\'>Domyślne</option>\n\
                  <option value=\'Czarno-białe\'>Czarno-białe</option>\n\
                  <option value=\'Sepia\'>Sepia</option>\n\
                </select>\n\
                <textarea rows="3" style="display: block; font-size: 10px; clear: both; margin-top: 7px;" cols="40" name="komentarz" placeholder="Komentarz do zamówienia"></textarea>
        <button id='podglad' class='zamow' onclick="
        if(document.getElementById('gallery').style.display=='none'){
            document.getElementById('podglad').style.backgroundColor='white';
            document.getElementById('podglad').style.boxShadow='0 0 5px 3px rgba(0,255,0,0.6)';
            document.getElementById('gallery').style.display='block';
	          document.getElementById('attributes').style.display='block';
            document.getElementById('img-'+nowShowed+'-preview').style.display='block';
	          document.getElementById('img-'+nowShowed+'-attr').style.display='block';
        } else {
            document.getElementById('gallery').style.display='none';
	          document.getElementById('attributes').style.display='none';
            document.getElementById('podglad').style.backgroundColor='#ddd';
            document.getElementById('podglad').style.boxShadow='0 0 5px 2px rgba(0,0,0,0.6)';
        } return false;">Rozwiń</button>
        <input type=\'submit\' onclick="return ret('odbitkiIn');" id=\'submitodbitki\' class=\'zamow\' name=\'odbitki\' value=\'Wyślij\'/> <br>\n\

    </div>
    <div class="product hdr" style="height: 300px; max-width: 850px; display: none; overflow: visible; padding: 0;" id="gallery"></div>
    <div class="product" style="display: none; overflow: visible; padding:0; max-height: none; text-align: center;" id="attributes"></div>
    </form>
    `);
        $('.active').removeClass("active");
        $('.odbitki').addClass("active");
    });

    $("#logo2").click(function(){
        document.getElementById('navbar2').classList.remove('is-active');
        $('.active').removeClass("active");
        onLd();
    });

    $(".ustawienia").click(function() {
        document.getElementById('navbar2').classList.remove('is-active');
        $('#main').load('subsites/settings.php');
        $('.active').removeClass("active");
        $('.ustawienia').addClass("active");
    });

    var e = jQuery.Event("keyup"); // or keypress/keydown
    e.keyCode = 27; // for Esc
    $(document).trigger(e);
    $(document).keyup(function(e) {
      if(e.keyCode==27) {
        document.getElementById('ldscreen').style.display = "none";
      }
    });

});


function imgToData(input) {
    cnt=0;
    nowShowed = 1;
    $('.mySlides').remove();
    $('.attrs').remove();
    document.getElementById('podglad').style.display='block';

    $.each(input.files, function(i, v) {
        var n = i + 1;
        cnt = cnt + 1 ;
        var File = new FileReader();
        File.onload = function(event) {
            $('<div/>').attr({
                class: 'mySlides',
                id: 'img-' + n + '-preview',
                style: 'width: 75%',
            }).appendTo('#gallery');
            $('<img/>').attr({
                src: event.target.result,
                style: 'max-height: 260px; width: auto; max-width: 100%;',
                id: n+'-img',
            }).appendTo('#img-' + n + '-preview');
	           drawAttr(n);
        };
        File.readAsDataURL(input.files[i]);
    });
    if(document.getElementById("attributes")){
      $("#gallery").append(`
          <a class="prev" onclick="
              document.getElementById('img-'+nowShowed+'-preview').style.display='none';
  	          document.getElementById('img-'+nowShowed+'-attr').style.display='none';
              nowShowed++;
              if(nowShowed>cnt) nowShowed=1;
              document.getElementById('img-'+nowShowed+'-preview').style.display='block';
  	          document.getElementById('img-'+nowShowed+'-attr').style.display='block';">&#10094</a>
          <a class="next" onclick="
              document.getElementById('img-'+nowShowed+'-preview').style.display='none';
  	          document.getElementById('img-'+nowShowed+'-attr').style.display='none';
              nowShowed--;
              if(nowShowed==0) nowShowed=cnt;
              document.getElementById('img-'+nowShowed+'-preview').style.display='block';
  	          document.getElementById('img-'+nowShowed+'-attr').style.display='block';">&#10095</a>
      `);
    } else {
      $("#gallery").append(`
          <a class="prev" onclick="
              document.getElementById('img-'+nowShowed+'-preview').style.display='none';
              nowShowed++;
              if(nowShowed>cnt) nowShowed=1;
              document.getElementById('img-'+nowShowed+'-preview').style.display='block';">&#10094</a>
          <a class="next" onclick="
              document.getElementById('img-'+nowShowed+'-preview').style.display='none';
              nowShowed--;
              if(nowShowed==0) nowShowed=cnt;
              document.getElementById('img-'+nowShowed+'-preview').style.display='block';">&#10095</a>
      `);
    }


}

function drawAttr(n) {
    $('<div/>').attr({
    class: 'attrs',
	id: 'img-' + n + '-attr',
	style: 'display: none;'
    }).appendTo('#attributes');


    $('<div>').attr({
	id: 'rozmiar',
	class: 'product attr col-xs-6 col-md-6 col-lg-3',
    }).html("<p>Rozmiar: </p>").appendTo('#img-'+n+'-attr');
    $('<select/>').attr({
	      class: 'select input',
	      name: n+'-rozmiar',
	      id: n+'-rozmiar',
    }).appendTo('#img-'+n+'-attr #rozmiar');
    $('<option/>').attr({
	value: '-',
    }).html("-").appendTo('#'+n+'-rozmiar');
    $('<option/>').attr({
	value: '9x13',
    }).html("9x13").appendTo('#'+n+'-rozmiar');
    $('<option/>').attr({
	value: '10x15',
    }).html("10x15").appendTo('#'+n+'-rozmiar');
    $('<option/>').attr({
	value: '13x18',
    }).html("13x18").appendTo('#'+n+'-rozmiar');
    $('<option/>').attr({
	value: '15x21',
    }).html("15x21").appendTo('#'+n+'-rozmiar');
    $('<option/>').attr({
	value: '20x30',
    }).html("20x30").appendTo('#'+n+'-rozmiar');


    $('<div>').attr({
	id: 'wypelnienie',
	class: 'product attr col-xs-12 col-md-6 col-lg-3',
    }).html("<p>Wypełnienie: </p>").appendTo('#img-'+n+'-attr');

    $('<select/>').attr({
	class: 'select input',
	name: n+'-wypelnienie',
	id: n+'-wypelnienie',
    }).html("Wypełnienie: ").appendTo('#img-'+n+'-attr #wypelnienie');
    $('<option/>').attr({
	value: '-',
    }).html("-").appendTo('#'+n+'-wypelnienie');
    $('<option/>').attr({
	value: 'dop',
    }).html("Dopasuj").appendTo('#'+n+'-wypelnienie');
    $('<option/>').attr({
	value: 'ndop',
    }).html("Przytnij").appendTo('#'+n+'-wypelnienie');


    $('<div>').attr({
	id: 'powierzchnia',
	class: 'product attr col-xs-12 col-md-6 col-lg-3',
    }).html("<p>Powierzchnia: </p>").appendTo('#img-'+n+'-attr');

    $('<select/>').attr({
	class: 'select input',
	name: n+'-powierzchnia',
	id: n+'-powierzchnia',
    }).appendTo('#img-'+n+'-attr #powierzchnia');
    $('<option/>').attr({
	value: '-',
    }).html("-").appendTo('#'+n+'-powierzchnia');
    $('<option/>').attr({
	value: 'mat',
    }).html("Mat").appendTo('#'+n+'-powierzchnia');
    $('<option/>').attr({
	value: 'błysk',
    }).html("Błysk").appendTo('#'+n+'-powierzchnia');

    $('<div>').attr({
  id: 'sepia',
  class: 'product attr col-xs-12 col-md-6 col-lg-3',
}).html("<p>Czarno-białe/Sepia: </p>").appendTo('#img-'+n+'-attr');

    $('<select/>').attr({
  class: 'select input',
  name: n+'-sepia',
  id: n+'-sepia',
  }).appendTo('#img-'+n+'-attr #sepia');
    $('<option/>').attr({
  value: '-',
  }).html("-").appendTo('#'+n+'-sepia');
  $('<option/>').attr({
  value: 'Domyślne',
}).html("Domyślne").appendTo('#'+n+'-sepia');
    $('<option/>').attr({
  value: 'Czarno-białe',
}).html("Czarno-białe").appendTo('#'+n+'-sepia');
    $('<option/>').attr({
  value: 'Sepia',
}).html("Sepia").appendTo('#'+n+'-sepia');



    $('<div>').attr({
	id: 'ilosc',
	class: 'product attr col-xs-12 col-md-6 col-lg-3',
  style: 'margin-top: 30px;'
    }).html("<p>Ilość: </p>").appendTo('#img-'+n+'-attr');
    $('<input/>').attr({
	type: 'number',
  class: 'input',
	min: '1',
	name: n+'-ilosc',
	placeholder: 'Ilość',
	style: 'width: 70px;'
    }).appendTo('#img-'+n+'-attr #ilosc');
}

function ret(txt) {
  var bul = confirm("Jesteś pewien?");
  if(bul == true) {
    if(document.getElementById(txt).checkValidity())
      ldScr(txt);
    return bul;
  } else {
    return bul;
  }
}

$(function(){
    $('#uploaded_file_file_for_upload').change(function(){
        var _URL = window.URL || window.webkitURL;
        var img, img_width = 0, img_height = 0, max_width = 1024, max_height = 768;
        var f = $(this)[0].files[0];
        alert(f.size);
        if (f.type == 'image/jpeg' || f.type == 'image/jpg') {
            img = new Image();
            img.onload = function () {
              img_width = this.width;
              img_height = this.height;
            };
            img.src = _URL.createObjectURL(f);
            if (img_width > max_width){
                img_height = Math.ceil(img_height * max_width / img_width);
                img_width = max_width;
            } else if (img_height > max_height) {
                img_width = Math.ceil(img_width * max_height / img_height);
                img_height = max_height;
            };
            resize(img, img_width, img_height);
            var f1 = $(this)[0].files[0];
            alert(f1.size);
        };

        function resize(image, width, height) {
          var mainCanvas = document.createElement("canvas");
          mainCanvas.width = width;
          mainCanvas.height = height;
          var ctx = mainCanvas.getContext("2d");
          ctx.drawImage(image, 0, 0, width, height);
          $('#uploaded_file_file_for_upload').attr('src', mainCanvas.toDataURL("image/jpeg"));
        };

        return false;

    });
});
