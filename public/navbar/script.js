let navigation = document.querySelector('.navigation');
let span3 = document.querySelector('.sp3');
let span5 = document.querySelector('.sp5');
let span6 = document.querySelector('.sp6');
let span7 = document.querySelector('.sp7');
let span8 = document.querySelector('.sp8');
let span9 = document.querySelector('.sp9');
navigation.onclick = function(){
    navigation.classList.toggle('active')
    span3.classList.toggle('active')
    span5.classList.toggle('active')
    span6.classList.toggle('active')
    span7.classList.toggle('active')
    span8.classList.toggle('active')
    span9.classList.toggle('active')
}