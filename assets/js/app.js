/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.scss in this case)
import('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

import axios from 'axios';
global.axios = axios;

function toggleDropdown(e)
{
    const dropdown = $(e.target).closest('.dropdown'),
        dropdownMenu = $('.dropdown-menu', dropdown);
    setTimeout(function () {
        const shouldOpen = e.type !== 'click' && dropdown.is(':hover');
        dropdownMenu.toggleClass('show', shouldOpen);
        dropdown.toggleClass('show', shouldOpen);
        $('[data-toggle="dropdown"]', dropdown).attr('aria-expanded', shouldOpen);
    }, e.type === 'mouseleave' ? 300 : 0);
}
$('body')
    .on('mouseenter mouseleave','.dropdown',toggleDropdown)
    .on('click', '.dropdown-menu a', toggleDropdown);

function onInput()
{
    const url = this.dataset.url;
    axios.get(url, {
        params: {
            query: this.value
        }
    })
        .then(function (response) {
            handleResponse(searchInput, response.data)
        })
        .catch(function (error) {
            console.log(error);
        });
}

function handleResponse(input, array)
{
    let currentFocus;
    let suggestionsList, suggestions, i, inputValue = input.value;
    closeAllLists();
    if (!inputValue) {
        return false;}
    currentFocus = -1;

    suggestionsList = document.createElement("DIV");
    suggestionsList.setAttribute("id", input.id + "autocomplete-list");
    suggestionsList.setAttribute("class", "autocomplete-items");
    suggestionsList.style.border = 'solid 1px';
    input.parentNode.appendChild(suggestionsList);

    for (i = 0; i < array.length; i++) {
        suggestions = document.createElement("DIV");
        suggestions.style.borderBottom = 'solid 1px';
        suggestions.innerHTML = array[i].name;
        suggestions.innerHTML += "<input type='hidden' value='" + array[i].name + "'>";
        suggestions.addEventListener("click", function (e) {
            input.value = this.getElementsByTagName("input")[0].value;
            closeAllLists();
        });
        suggestionsList.appendChild(suggestions);
    }

    input.addEventListener("keydown", function (e) {
        let suggestion = document.getElementById(this.id + "autocomplete-list");
        if (suggestion) {
            suggestion = suggestion.getElementsByTagName("div");
        }
        if (e.keyCode === 40) {
            currentFocus++;
            addActive(suggestion);
        } else if (e.keyCode === 38) {
            currentFocus--;
            addActive(suggestion);
        } else if (e.keyCode === 13) {
            e.preventDefault();
            if (currentFocus > -1) {
                if (suggestion) {
                    suggestion[currentFocus].click();
                }
            }
        }
    });
    function addActive(suggestion)
    {
        if (!suggestion) {
            return false;
        }
        removeActive(suggestion);
        if (currentFocus >= suggestion.length) {
            currentFocus = 0;
        }
        if (currentFocus < 0) {
            currentFocus = (suggestion.length - 1);
        }
        /*add class "autocomplete-active":*/
        suggestion[currentFocus].classList.add("text-primary");
        suggestion[currentFocus].classList.add("font-weight-bold");
    }
    function removeActive(suggestion)
    {
        for (let i = 0; i < suggestion.length; i++) {
            suggestion[i].classList.remove("text-primary");
            suggestion[i].classList.remove("font-weight-bold");
        }
    }
    function closeAllLists(elmnt)
    {
        let suggestion = document.getElementsByClassName("autocomplete-items");
        for (let i = 0; i < suggestion.length; i++) {
            if (elmnt !== suggestion[i] && elmnt !== input) {
                suggestion[i].parentNode.removeChild(suggestion[i]);
            }
        }
    }
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}

function debounce(callback, delay)
{
    let timer;
    return function () {
        let args = arguments;
        let context = this;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, delay)
    }
}

const searchInput = document.getElementById('playerSearch');
if (searchInput !== null) {
    searchInput.addEventListener("input", debounce(onInput, 350));
}
