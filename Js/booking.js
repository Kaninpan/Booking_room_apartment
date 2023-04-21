const rooms = document.querySelectorAll('.rooms');
const selecroom = document.getElementById("selecroom");

const roomid = document.querySelectorAll(".roomid");
const roomide = document.querySelectorAll('.roomide');
console.log (roomid)

rooms.forEach(e => {
    e.addEventListener('click',e=>{
        if(e.target.classList[0] == 'rooms'){
        removecheck()
        e.target.classList.add('check');
        selecroom.value=`${e.target.children[0].innerText}`;
        }
    })

    roomide.forEach(a=>{
        if(a.innerHTML == e.childNodes[1].innerHTML){
            // const sss = document.querySelector(.${e.target.classList[1]})
            // console.log(a.innerHTML)
            // console.log(e.childNodes[1].innerHTML)
         
            e.classList.add('active')
            // removerooms();
            e.classList.remove('rooms')
            // e.innerText="มีผู้เช่า";
            // console.log(a)
            // console.log(e.classList)
        }
    })
    roomid.forEach(a=>{
        // console.log(a)
        if(a.innerHTML == e.childNodes[1].innerHTML){
            // const sss = document.querySelector(.${e.target.classList[1]})
            // console.log(a.innerHTML)
            // console.log(e.childNodes[1].innerHTML)
         
            e.classList.add('closs')
            // removerooms();
            e.classList.remove('rooms')
            // e.innerText="มีผู้เช่า";
            // console.log(a)
            // console.log(e.classList)
        }
    })
});



function removecheck(){
    for(let i=0;i<rooms.length;i++){
        rooms[i].classList.remove('check');
        // rooms[i].innerHTML="";
    }
}


