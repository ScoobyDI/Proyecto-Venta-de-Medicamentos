const   aside = document.getElementById('aside');
        menu = document.getElementById('menu');

menu.onclick = () => {
    aside.classList.toggle('active');
}

const listElements = document.querySelectorAll('.aside__list__button');

listElements.forEach(listElement => {
    listElement.addEventListener('click',()=>{
        listElement.classList.toggle('arrow')

        let height=0;
        let submenu = listElement.nextElementSibling;           //toma a elemento adyacent a list Element (.aside__list__button)

        if(submenu.clientHeight == "0"){
            height = submenu.scrollHeight;
        }

        submenu.style.height = `${height}px`;
    })
});
