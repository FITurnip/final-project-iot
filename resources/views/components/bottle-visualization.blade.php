<div class="bottle {{ $rotated ? 'bottle-rotated' : '' }}">
    <div class="bottle-neck"></div>
    <div class="water" style="height: {{ $waterLevel }}%;"></div>
  </div>
  
  <style>
    :root .bottle {
        --bottom: #00f;;
        --top: #6c757d;
    }
    
    .bottle {
      position: relative;
      width: 100px;
      height: 300px;
      background-color: var(--bottom);
      border-radius: 50px 50px 10px 10px;
      margin: 50px auto;
    }
    .bottle-neck {
      position: absolute;
      top: -30px;
      left: 30px;
      width: 40px;
      height: 40px;
      background-color: var(--bottom);
      border-radius: 10px 10px 0 0;
    }
    .bottle-rotated {
      transform: rotate(180deg);
    }
    .water {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      background-color: var(--top);
      border-radius: 0 0 10px 10px;
    }
  </style>
  