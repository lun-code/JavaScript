const dptSelect = document.getElementById("departamento")
const dptSpan = document.getElementById("departamento-name")
const miembrosUl = document.getElementById("miembros")

// Crear dpto
const dptoNameInput = document.getElementById('nombre_Departamento')
const dptoDescripInput = document.getElementById('descripcion')
const crearDepartamentoBtn = document.getElementById('crear_departamento')

// Añadir miembro
const nombre_miembro = document.getElementById('nombre_miembro')
const apellido_miembro = document.getElementById('apellido_miembro')
const email_miembro = document.getElementById('email_miembro')
const telefono_miembro = document.getElementById('telefono_miembro')
const departamentoID_miembro = document.getElementById('departamentoID_miembro')
const add_miembro = document.getElementById('add_miembro')


fetch('getDpts.php').then(response => response.json()).then(data => {
    
    data.forEach(departamento => {
        let newOption = document.createElement('option')
        newOption.value = departamento.DepartamentoID
        newOption.textContent = departamento.NombreDepartamento
        dptSelect.appendChild(newOption)
    })

    data.forEach(departamento => {
        let newOption = document.createElement('option')
        newOption.value = departamento.DepartamentoID
        newOption.textContent = departamento.NombreDepartamento
        departamentoID_miembro.appendChild(newOption)
    })
})

crearDepartamentoBtn.addEventListener('click', function(){
    let NombreDepartamento = dptoNameInput.value.trim()
    let descripcion = dptoDescripInput.value.trim()

    if(NombreDepartamento && descripcion){

        let options = {
            method: 'POST',
            body: new URLSearchParams({
                nombre_departamento: NombreDepartamento,
                descripcion: descripcion
            })
        }

        fetch('insertDpt.php', options).then(response => response.json()).then(data => {
            if(data.error){
                console.error('Error al crear el departamento', data.error)
            }else{
                console.log('Departamento creado con ID', data.mensaje)
            }
        })
    }
})

add_miembro.addEventListener("click", function(){

    let fecha = new Date()

    let nombre = nombre_miembro.value
    let apellido = apellido_miembro.value
    let email = email_miembro.value
    let departamento_id = departamentoID_miembro.value
    let fechaIngreso = `${fecha.getFullYear()}/${fecha.getMonth()}/${fecha.getDate()}`
    let telefono = telefono_miembro.value

    if(nombre && apellido && email && departamento_id && fechaIngreso){

        let options = {
            method: 'POST',
            body: new URLSearchParams({
                nombre: nombre,
                apellido: apellido,
                email: email,
                departamento_id: departamento_id,
                fecha_ingreso: fechaIngreso,
                telefono: telefono
            })
        }

        fetch('insertMember.php', options).then(response => response.json()).then(data => {
            if(data.error){
                console.error('Error al crear el miembro', data.error)
            }else{
                console.log('Añadido miembro con ID', data.mensaje)
            }
        })
    }
})

dptSelect.addEventListener('change', function() {

    miembrosUl.innerHTML = ""

    if(this.value > 0){
        let departamentoName = this.options[this.selectedIndex].textContent
        dptSpan.textContent = departamentoName
        fetch(`getMembers.php?departamento=${departamentoName}`).then(response => response.json()).then(data => {

            data.forEach(miembro => {
                let newLi = document.createElement('li')
                newLi.textContent = `${miembro.Nombre} ${miembro.Apellido}`
                miembrosUl.appendChild(newLi)
            })
        })
    }else{
        dptSpan.textContent = "---Selecciona un departamento---"
        miembrosUl.innerHTML = ""
    }
    
})