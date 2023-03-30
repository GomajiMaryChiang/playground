function autocomplete(inp, option = {}) {
  if (option.plat == 'mm') {
    showDefaultKeyword(inp);
  }
  /* the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values: */
  /* execute a function when someone writes in the text field: */
  inp.addEventListener('input', function(e) {
    var element = this;
    var val = element.value;
    if (!val || val.length < 2 || option.plat == 'mm') {
      showDefaultKeyword(element);
    } else {
      fetch(option.autocompleteUrl + '?keyword=' + val).then(function(response) {
        return response.json().then(function(res) {
          if ('0000' == res.return_code) {
            /* close any already open lists of autocompleted values */
            closeAllLists();
            let wrapDiv, item, ul, i, li;
            let arr = [];
            res.data.keywords.forEach(function(row) {
              arr.push(row.text);
            });
            if (0 == arr.length) {
              return false;
            }
            
            /* create a DIV element that will contain the items (values): */
            wrapDiv = createWrapPC();

            /* append the DIV element as a child of the autocomplete container: */
            element.parentNode.parentNode.parentNode.parentNode.appendChild(wrapDiv);

            ul = document.createElement('ul');

            /* for each item in the array... */
            for (i = 0; i < arr.length; i++) {
              /* create a DIV element for each matching element: */
              item = createItemPC();
              li = document.createElement('li');
              li.appendChild(item);

              /* make the matching letters bold: */
              item.innerHTML += '<strong>' + arr[i].substr(0, val.length) + '</strong>';
              item.innerHTML += arr[i].substr(val.length);
              /* insert a input field that will hold the current array item's value: */
              item.innerHTML += '<input type="hidden" value="' + arr[i] + '">';
              /* check if the item starts with the same letters as the text field value: */
              if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /* execute a function when someone clicks on the item value (DIV element): */
                item.addEventListener('click', function(e) {
                  /* insert the value for the autocomplete text field: */
                  inp.value = this.getElementsByTagName('input')[0].value;
                  /* close the list of autocompleted values,
                  (or any other open lists of autocompleted values: */
                  closeAllLists();

                  if (option.plat == 'pc') {
                    element.parentElement.submit();
                  } else {
                    element.parentElement.parentElement.submit();
                  }
                });
                ul.appendChild(li);
              }
            }
            wrapDiv.appendChild(ul);
          }
        });
      });
    }
  });
  inp.addEventListener('click', function (e) {
    if (2 > this.value.length) {
      showDefaultKeyword(this);
    }
  });
  function showDefaultKeyword(element) {
    let wrapDiv, item, ul, i, li, val = element.value;
    let dataExist = (option.defaultKeyword.length > 0 ? true : false);

    /* close any already open lists of autocompleted values */
    closeAllLists();
    if (!dataExist) {
      return false;
    }

    if (option.plat == 'pc') {
      /* create a DIV element that will contain the items (values): */
      wrapDiv = createWrapPC();

      /* append the DIV element as a child of the autocomplete container: */
      element.parentNode.parentNode.parentNode.parentNode.appendChild(wrapDiv);
    } else {
      /* create a DIV element that will contain the items (values): */
      wrapDiv = createWrapMM();

      /* append the DIV element as a child of the autocomplete container: */
      element.parentNode.parentNode.parentNode.appendChild(wrapDiv);
    }

    ul = document.createElement('ul');

    /* for each item in the array... */
    for (i = 0; i < option.defaultKeyword.length; i++) {
      /* create a DIV element for each matching element: */
      if (option.plat == 'pc') {
        item = createItemPC();
      } else {
        item = createItemMM();
      }
      li = document.createElement('li');
      li.appendChild(item);

      /* make the matching letters bold: */
      if (option.defaultKeyword[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
        item.innerHTML = '<strong>' + option.defaultKeyword[i].substr(0, val.length) + '</strong>';
      } else {
        item.innerHTML = option.defaultKeyword[i].substr(0, val.length);
      }
      item.innerHTML += option.defaultKeyword[i].substr(val.length);
      /* insert a input field that will hold the current array item's value: */
      item.innerHTML += '<input type="hidden" value="' + option.defaultKeyword[i] + '">';
      /* execute a function when someone clicks on the item value (DIV element): */
      item.addEventListener('click', function(e) {
        /* insert the value for the autocomplete text field: */
        inp.value = this.getElementsByTagName('input')[0].value;
        /* close the list of autocompleted values,
        (or any other open lists of autocompleted values: */
        closeAllLists();

        if (option.plat == 'pc') {
          element.parentElement.submit();
        } else {
          element.parentElement.parentElement.submit();
        }
      });
      ul.appendChild(li);
    }
    wrapDiv.appendChild(ul);

    if (option.hasOwnProperty('cleanDefault') && option.cleanDefault && dataExist) {
      /* clean all */
      let cleanName = (option.hasOwnProperty('cleanName') ? option.cleanName : '清除搜尋記錄');
      b = document.createElement("a");
      b.setAttribute('href', 'javascript:;');
      b.classList.add('clear-results');
      b.innerHTML = cleanName;
      b.addEventListener('click', function(e) {
        option.cleanDefaultCallback(e);
        option.defaultKeyword = [];
        closeAllLists(e.target);
      });
      wrapDiv.appendChild(b);
    }
  }
  function closeAllLists(elmnt)
  {
    /* close all autocomplete lists in the document,
    except the one passed as an argument: */
    var x = document.getElementsByClassName('autocomplete_item');
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }

  function createWrapPC()
  {
    let wrapDiv = document.createElement('DIV');

    wrapDiv.setAttribute('id', 'popularWrap');
    wrapDiv.classList.add('keyword_rank');
    wrapDiv.classList.add('autocomplete_item');
    wrapDiv.setAttribute('style', 'display: initial;');

    return wrapDiv;
  }

  function createWrapMM()
  {
    let wrapDiv = document.createElement('DIV');

    wrapDiv.classList.add('results');
    wrapDiv.classList.add('autocomplete_item');
    wrapDiv.innerHTML = '<h3 class="t-gray">最近搜尋</h3>';

    return wrapDiv;
  }

  function createItemPC()
  {
    let item = document.createElement('a');

    item.setAttribute('href', 'javascript:;');
    item.classList.add('rank-link');

    return item;
  }

  function createItemMM()
  {
    let item = document.createElement('a');

    item.setAttribute('href', 'javascript:;');
    item.classList.add('t-darkgray');
    item.innerHTML = '<i class="icon i-search-gray mr-2"></i>';

    return item;
  }
}