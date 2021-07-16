@extends('common.base')

@section('content')

<main class='container'>
  <form action="{{ url('/') }}" method="post" class="plate" name="numberPlateForm">
    @csrf
    <div></div>
    <div id="numberplate">
      <div class="number-sealed"></div>
      <div class="number-top">
        <input 
          type="text"
          name="regional_name"
          id="home-base"
          placeholder="品川"
          value="{{ $rn }}品川"
          maxlength="3"
          require
        >
        <input 
          type="number"
          name="category_number"
          id="class-number"
          placeholder="500"
          value="{{ $cn }}500"
          min="000"
          max="999"
          maxlength="3"
          require
        >
      </div>
      <div class="number-buttom">
        <input 
          type="text"
          name="hiragana"
          class="left-kana"
          placeholder="あ"
          value="{{ $hi }}あ"
          maxlength="1"
          require
        >
        
        <input 
          type="number"
          name="specified_number_1"
          class="center-number"
          placeholder="・"
          value="{{ $s1 }}"
          min="0"
          max="9"
          maxlength="1"
        >
        <input 
          type="number"
          name="specified_number_2"
          class="center-number"
          placeholder="・"
          value="{{ $s2 }}"
          maxlength="1"
        >
        <div class="number-hyphen"></div>
        <input
          type="number"
          name="specified_number_3"
          class="center-number"
          placeholder="・"
          value="{{ $s3 }}"
          maxlength="1"
        >
        <input 
          type="number"
          name="specified_number_4"
          class="center-number"
          placeholder="・"
          value="{{ $s4 }}"
          maxlength="1"
        >
      </div>
    </div>
    <div>
      <ul class="plate-color">
        <li><input id="white" class="white" type="radio" name="colors" value="white"  checked></li>
        <li><input id="green" class="green" type="radio" name="colors" value="green" ></li>
        <li><input id="yellow" class="yellow" type="radio" name="colors" value="yellow"></li>
        <li><input id="black" class="black" type="radio" name="colors" value="black" ></li>
        <li><input id="blue" class="blue" type="radio" name="colors" value="blue" ></li>
      </ul>
    </div>
    <div></div>
    <div class="btn-wrap">
      <a id="btn1" href="{{ url('upload/') }}">画像で検索</a>
      <button id="btn2" type="submit">検索</button>
    </div>
  </form>
</main>

@endsection('content')


@section('extra_javascript')

  <script>

    let plate = document.getElementById('numberplate');
    let btn1 = document.getElementById('btn1');
    let btn2 = document.getElementById('btn2');
    const number_plate = document.getElementById('numberplate');
    let inputes = number_plate.querySelectorAll('input');

    const color_list = {
      "white"  : "#f8f9fa",
      "green"  : "#198754",
      "yellow" : "#ffc107",
      "black"  : "#343a40",
      "blue"   : "#0dcaf0",
    }

    const color_class = [
      "plate-white" ,
      "plate-green" ,
      "plate-yellow",
      "plate-black" ,
      "plate-blue"  ,
    ]
    
    var rad = document.numberPlateForm.colors;
    var prev = null;
    for (var i = 0; i < rad.length; i++) {
      rad[i].addEventListener('change', function() {
          (prev) ? prev.value: null;
          if (this !== prev) {
              prev = this;
          }
          //input
          plate.style.backgroundColor = color_list[this.id];
          for(let i = 0; i < inputes.length; i++) {
            inputes[i].classList.remove(...color_class);
            inputes[i].classList.add(`plate-${this.id}`);
          }
          //button
          if (this.id == 'white') {
            btn1.style.borderColor = color_list['green'];
            btn1.style.color = color_list['green'];
            btn2.style.borderColor = color_list['green'];
            btn2.style.backgroundColor = color_list['green'];
          }else{
            btn1.style.borderColor = color_list[this.id];
            btn1.style.color = color_list[this.id];
            btn2.style.borderColor = color_list[this.id];
            btn2.style.backgroundColor = color_list[this.id];
          }
      });
    }

  </script>

@endsection