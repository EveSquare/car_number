<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>car_number</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('css/number.css') }}">
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Car_number</a>
      </div>
    </nav>
  </header>

  <main class='container'>
    <form action="" method="post" class="plate" name="numberPlateForm">
      <div></div>
      <div id="numberplate">
        <div class="number-sealed"></div>
        <div class="number-top">
          <input 
            type="text"
            name="regional_name"
            id="home-base"
            placeholder="品川"
            maxlength="3"
          >
          <input 
            type="text"
            name="category_number"
            id="class-number"
            placeholder="500"
            min="000"
            max="999"
            maxlength="3"
          >
        </div>
        <div class="number-buttom">
          <input 
            type="text"
            name="hiragana"
            class="left-kana"
            placeholder="あ"
            maxlength="1"
          >
          
          <input 
            type="number"
            name="specified_number_1"
            class="center-number"
            placeholder="・"
            min="0"
            max="9"
            maxlength="1"
          >
          <input 
            type="number"
            name="specified_number_2"
            class="center-number"
            placeholder="・"
            maxlength="1"
          >
          <div class="number-hyphen"></div>
          <input
            type="number"
            name="specified_number_3"
            class="center-number"
            placeholder="・"
            maxlength="1"
          >
          <input 
            type="number"
            name="specified_number_4"
            class="center-number"
            placeholder="・"
            maxlength="1"
          >
        </div>
      </div>
      <div>
        <ul class="plate-color">
          <li><input id="white" class="white" type="radio" name="colors" checked></li>
          <li><input id="green" class="green" type="radio" name="colors"></li>
          <li><input id="yellow" class="yellow" type="radio" name="colors"></li>
          <li><input id="black" class="black" type="radio" name="colors"></li>
          <li><input id="blue" class="blue" type="radio" name="colors"></li>
        </ul>
      </div>
    </form>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

  <script>

    let plate = document.getElementById('numberplate');

    const color_list = {
      "white"  : "#f8f9fa",
      "green"  : "#16631a",
      "yellow" : "#e2ec4e",
      "black"  : "#141414",
      "blue"   : "#2196f3",
    }
    
    var rad = document.numberPlateForm.colors;
    var prev = null;
    for (var i = 0; i < rad.length; i++) {
        rad[i].addEventListener('change', function() {
            (prev) ? prev.value: null;
            if (this !== prev) {
                prev = this;
            }
            plate.style.backgroundColor=color_list[this.id];
        });
    }

  </script>
</body>
</html>