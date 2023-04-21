const country = document.querySelector(".country");
const district = document.querySelector(".district");
const districts = document.querySelectorAll(".districts");
const tambon = document.querySelector(".tambon");
const tambons = document.querySelectorAll(".tambons");
const postcode = document.querySelector(".postcode");
const postcodes = document.querySelectorAll(".postcodes");


country.addEventListener("click",()=>{
    let select = country.options[country.selectedIndex].value;
    districts.forEach(e=>{
        if(e.id != select){
            e.style.display="none"
        }else{
            e.style.display="flex"
        }
    })
    
})


district.addEventListener("click",()=>{
    let select = district.options[district.selectedIndex].value;
    tambons.forEach(e=>{
        if(e.id != select){
            e.style.display="none"
        }else{
            e.style.display="flex"
        }
    })

})
tambon.addEventListener("click",()=>{
    let select = tambon.options[tambon.selectedIndex].value;
    postcodes.forEach(e=>{
        if(e.id != select){
            e.style.display="none"
        }else{
            e.style.display="flex"
        }
    })

})



