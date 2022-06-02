//varaibles
const carrito = document.querySelector('#carrito');
const contenedorCarrito = document.querySelector('#lista-carrito tbody');
const vaciarCarritoBtn = document.querySelector('#vaciar-carrito');
const listaCursos = document.querySelector('#lista-cursos');
let articulosCarrito = [];

cargarEventListeners();
function cargarEventListeners(){ 
    listaCursos.addEventListener('click', agregarCurso);
    carrito.addEventListener('click',eliminarCurso);
    //Elimina todos los cursos del carrito

    vaciarCarritoBtn.addEventListener('click',()=>{
        console.log(e.target);
        articulosCarrito=[];
        carritoHTML();
    });
}

//Funciones

//Cuando agregas un curso presionando "Agregar al Carrito"
function agregarCurso(e){
    e.preventDefault();
    if(e.target.classList.contains('agregar-carrito')){
        cursoSeleccionado= e.target.parentElement.parentElement;
        leerDatosCurso(cursoSeleccionado);
    }
}

//Eliminar un curso del carrito
function eliminarCurso(e){
    if(e.target.classList.contains('borrar-curso')){
        //actualizarCantidad(e.target.getAttribute('data-id')); Mi función
        
        const cursoId = e.target.getAttribute('data-id');

        //elimina del arreglo de articulosCarrito por el data-id;
        articulosCarrito = articulosCarrito.filter(curso =>curso.id!==cursoId);
        carritoHTML();
    }
}



function actualizarCantidad(idCurso){//El profesor usa el botón para eliminar el curso,
                                    //PERO yo lo utilizo para reducir la cantidad en 1
    const cursos = articulosCarrito.map(curso =>{
        if(curso.id===idCurso){
            curso.cantidad--;
            return curso;
        }else{
            return curso;
        }
    });
    articulosCarrito = cursos.filter(curso=>curso.cantidad>0);
    console.log(articulosCarrito);
    carritoHTML();
}   


//Lee el contenido del HTML al que le dimos click 
//y extrae la información del curso
function leerDatosCurso(curso){
    
    //Creamos un objet con el contenido del curso seleccionado
    const infoCurso = {
        imagen: curso.querySelector('img').src,
        titulo: curso.querySelector('h4').textContent,
        precio: curso.querySelector('.precio span').textContent,
        id: curso.querySelector('a').getAttribute('data-id'),
        cantidad:1
    }
    //revisa si un elemento ya existe en el carrito
    const existe = articulosCarrito.some(curso=>curso.id ===infoCurso.id)

    /*if(existe){  // MI CÓDIGO XD
        //Actualizamos la cantidad
        articulosCarrito.forEach((curso)=>{
            if(curso.id===infoCurso.id){
                curso.cantidad++;
            }
        });
    }else{
        //Agrega elementos al arreglo de Carrito
        articulosCarrito = [...articulosCarrito, infoCurso];
    }*/
    
    if(existe){
        const cursos = articulosCarrito.map(curso =>{
            if(curso.id === infoCurso.id){//En los arrow funcion se dan por implícito los return
                            //cuando el código se queda en una sola línea, pero este
                            //no es el caso, así que tenemos que ponerlo
                curso.cantidad++;
                return curso;//retorna el objeto actualizado
            }else{
                return curso;//retorna los objetos que no son duplicados
            }
        });
    
        articulosCarrito = [...cursos];
    }else{
        //Agrega elementos al arreglo de Carrito
        articulosCarrito = [...articulosCarrito, infoCurso];
    }
    
    carritoHTML();
}

//Muestra el Carrito de compras en el HTML
function carritoHTML(){
    //Limpiar el HTML
    limpiarHTML();
    //Recorre el carrito y genera le HTML
    articulosCarrito.forEach((curso) => {
        
        const {imagen,titulo,precio,cantidad,id}=curso;
        const row = document.createElement('tr');
        row.innerHTML = `
        <td>
            <img src="${imagen}" width="100">
        </td>
        <td>${titulo}</td>
        <td>${precio}</td>
        <td>${cantidad}</td>
        <td>
            <a href="#" class="borrar-curso" data-id="${id}"> X </a>
        </td>
        `;

        contenedorCarrito.appendChild(row);
    });
}

//Elimina los cursos del tbody
function limpiarHTML(){
    
    //Forma lenta
    //contenedorCarrito.innerHTML = ' ';

    //Forma rápida
    while(contenedorCarrito.firstChild){
        contenedorCarrito.removeChild(contenedorCarrito.firstChild);
    }

}

