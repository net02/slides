bubbleSort = function(array) {
    var start = new Date();
    var i, j;
    var newarray = array.slice(0);
    var swap = function(j, k) {
      var temp = newarray[j];
      newarray[j] = newarray[k];
      newarray[k] = temp;
      return(true);
    }
    var swapped = false;
    for(i=1; i<newarray.length; i++) {
      for(j=0; j<newarray.length - i; j++) {
        if (newarray[j+1] < newarray[j]) {
          swapped = swap(j, j+1);
        }
      }
      if (!swapped) break;
    }
    var end = new Date();
    elapsed = end.getTime() - start.getTime();
    console.log('Tempo di esecuzione (ms): ' + elapsed);
    return newarray;
}

qsort = function(a) {
    if (a.length == 0) return [];

    var left = [], right = [], pivot = a[0];

    for (var i = 1; i < a.length; i++) {
        a[i] < pivot ? left.push(a[i]) : right.push(a[i]);
    }

    return qsort(left).concat(pivot, qsort(right));
}

quickSort = function(array) {
    var start = new Date();
    var newarray = qsort(array);

    var end = new Date();
    elapsed = end.getTime() - start.getTime();
    console.log('Tempo di esecuzione (ms): ' + elapsed);
    return newarray;
}

randomArray = function(size) {
    var random = [];
    for (var i=0, t=size; i<t; i++) {
        random.push(Math.round(Math.random() * t));
    }
    return random;
}

sortedArray = function(size) {
    var sorted = [];
    for (var i=0, t=size; i<t; i++) {
        sorted.push(i);
    }
    return sorted;
}
