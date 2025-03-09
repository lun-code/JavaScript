const txtAdd = document.querySelector("#txtAdd")
const btnAdd = document.querySelector("#btnAdd")
const mylist = document.querySelector("#mylist")
const btnSelAll = document.querySelector("#btnSelAll")
const btnSelNot = document.querySelector("#btnSelNot")
const btnInvSel = document.querySelector("#btnInvSel")
const btnMovSel = document.querySelector("#btnMovSel")
const mycart = document.querySelector("#mycart")
const btnEmpCar = document.querySelector("#btnEmpCar")

btnAdd.addEventListener("click", addToList)

btnSelAll.addEventListener("click", function(){
    let lista = document.querySelectorAll("#mylist li")
    
    lista.forEach(elemento => {
        elemento.classList.add("seleccionado")
    })
})

btnSelNot.addEventListener("click", function(){
    let lista = document.querySelectorAll("#mylist li")
    
    lista.forEach(elemento => {
        elemento.classList.remove("seleccionado")
    })
})

btnInvSel.addEventListener("click", function(){
    let lista = document.querySelectorAll("#mylist li")
    
    lista.forEach(elemento => {
        if(elemento.classList.contains("seleccionado")){
            elemento.classList.remove("seleccionado")
        }else{
            elemento.classList.add("seleccionado")
        }
    })
})

btnMovSel.addEventListener("click", function(){
    let lista = document.querySelectorAll("#mylist li")
    
    lista.forEach(elemento => {
        if(elemento.classList.contains("seleccionado")){
            mycart.append(elemento)
            elemento.classList.remove("seleccionado")
        }
    })
})

btnDelSel.addEventListener("click", function(){
    let lista = document.querySelectorAll("#mylist li")
    
    lista.forEach(elemento => {
        if(elemento.classList.contains("seleccionado")){
            elemento.remove()
        }
    })
})

btnEmpCar.addEventListener("click", function(){
    let lista = document.querySelectorAll("#mycart li")

    lista.forEach(elemento => {
        elemento.remove()
    })
})

function addToList(){
    let li = document.createElement("li")
    li.textContent = txtAdd.value
    mylist.append(li)

    li.addEventListener("click", function(){
        li.classList.toggle("seleccionado")
    })

    txtAdd.value = ""
}