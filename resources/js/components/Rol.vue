<template>

  <div id="content-wrapper">

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Gestionar</a>
          </li>
          <li class="breadcrumb-item active">Roles</li>
        </ol>

        <!-- Datos en tablas -->
        <div class="card mb-3">

          <div class="card-header">
            <i class="fas fa-table"></i>
            Todos los roles del sistema
            <button type="button" @click="abrirModal('rol','registrar')" class="btn btn-primary">
              <i class="fas fa-plus-square"></i>&nbsp;Nuevo
            </button>
          </div>

          <div class="card-body">

            <div class="form-group row">
              <div class="col-md-8">
                <div class="input-group">
                  <select class="form-control col-md-4" v-model="criterio">
                  <option value="rol">Rol</option>
                  
                  </select>
                  <input type="text" v-model="buscar" @keyup.enter="listarRol(1,buscar,criterio)" class="form-control" placeholder="Buscar Rol (Administrador)">
                  <button type="submit" @click="listarRol(1,buscar,criterio)" class="btn btn-primary"><i class="fas fa-search-location"></i> Buscar</button>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr class="table-secondary">
                    <th>Opciones</th>
                    <th>Rol</th>
                    <th>Condición</th>
                  </tr>
                </thead>
                
                <tbody>
                  <tr v-for="rol in arrayRol" :key="rol.id">
                    <td>
                      <button type="button" @click="abrirModal('rol','actualizar',rol)" class="btn btn-warning btn-sm" >
                        <i class="fas fa-pen"></i>
                      </button>
                      <template v-if="rol.condicion">
                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarRol(rol.id)">
                          <i class="fas fa-trash"></i>
                        </button>
                      </template>
                      <template v-else>
                        <button type="button" class="btn btn-info btn-sm" @click="activarRol(rol.id)">
                          <i class="fas fa-check"></i>
                        </button>
                      </template>
                    </td>
                    <td v-text="rol.rol"></td>
                    <td>
                      <div v-if="rol.condicion">
                          <span class="badge badge-success">Activo</span>
                      </div>
                      <div v-else>
                          <span class="badge badge-danger">Desactivado</span>
                      </div>
                    </td>
                  </tr>                  
                </tbody>
              </table>
              <nav>
                <ul class="pagination">
                  <li class="page-item" v-if="pagination.current_page > 1">
                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                  </li>
                  <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                  </li>
                  <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
          
          <!-- Modal Registrar Actualizar-->
          <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" v-text="tituloModal"></h5>
                  <button class="close" type="button" @click="cerrarModal()" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="text-input">Rol</label>
                    <div class="col-md-9">
                      <input type="text" v-model="rol" class="form-control" placeholder="Admin...">                                        
                    </div>
                  </div>
                       
                  <div v-show="errorRol" class="form-group row div-error">
                    <div class="text-center text-error">
                      <div v-for="error in errorMostrarMsjRol" :key="error" v-text="error">
                      </div>
                    </div>
                  </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                  <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarRol()">Guardar</button>
                  <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarRol()">Actualizar</button>
                </div>
              </div>
            </div>
          </div>

        </div>

    </div>

  </div>
</template>

<script>
    export default {
      data(){
        return {
          rol_id:0,
          rol:'',
          arrayRol:[],
          modal : 0,
          tituloModal : '',
          tipoAccion : 0,
          errorRol : 0,
          errorMostrarMsjRol : [],
          pagination : {
            'total' : 0,
            'current_page' : 0,
            'per_page' : 0,
            'last_page' : 0,
            'from' : 0,
            'to' : 0,
          },
          offset : 3,
          criterio : 'rol',
          buscar : '',
        }
      },
      computed:{
        isActived: function(){
          return this.pagination.current_page;
        },
        pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
        }
      },
      methods : {
        listarRol (page,buscar,criterio){
          let me=this;
          var url='/rol?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
          axios.get(url).then(function (response) {
            var respuesta= response.data;
            me.arrayRol = respuesta.roles.data;
            me.pagination= respuesta.pagination;
          }).catch(function (error) {
            console.log(error);
          });
        },
        cambiarPagina(page,buscar,criterio){
          let me = this;
          //Actualiza la página actual
          me.pagination.current_page = page;
          //Envia la petición para visualizar la data de esa página
          me.listarRol(page,buscar,criterio);
        },
        registrarRol(){
          let me = this;
          if (me.validarRol()){
              return;
          }
          
          axios.post('/rol/registrar',{
              'rol': me.rol,
          }).then(function (response) {
              me.cerrarModal();
              me.listarRol(1,'','rol');
          }).catch(function (error) {
              console.log(error);
          });
        },
        actualizarRol(){
          let me = this;
          if (me.validarRol()){
              return;
          }
          axios.put('/rol/actualizar',{
            'rol': this.rol,
            'id': me.rol_id,
          }).then(function (response) {
              me.cerrarModal();
              me.listarRol(1,'','rol');
          }).catch(function (error) {
              console.log(error);
          }); 
        },
        desactivarRol(id){
          swal({
          title: '¿Estás seguro de desactivar este rol?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si!',
          cancelButtonText: 'No',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
          reverseButtons: true
          }).then((result) => {
          if (result.value) {
              let me = this;

              axios.put('/rol/desactivar',{
                  'id': id
              }).then(function (response) {
                  me.listarRol(1,'','rol');
                  swal(
                  'Desactivado!',
                  'El rol ha sido desactivado con éxito.',
                  'success'
                  )
              }).catch(function (error) {
                  console.log(error);
              });
            
          } else if (
            result.dismiss === swal.DismissReason.cancel
          ) {
              
          }
          }) 
        },
        activarRol(id){
            swal({
            title: '¿Estás activando este rol?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si!',
            cancelButtonText: 'No',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                let me = this;

                axios.put('/rol/activar',{
                    'id': id
                }).then(function (response) {
                    me.listarRol(1,'','rol');
                    swal(
                    'Activado!',
                    'El rol ha sido activado con éxito.',
                    'success'
                    )
                }).catch(function (error) {
                    console.log(error);
                });
             
            } else if (
              result.dismiss === swal.DismissReason.cancel
            ) {
                
            }
            }) 
        },
        validarRol(){
          this.errorRol=0;
          this.errorMostrarMsjRol =[];

          if (!this.rol) this.errorMostrarMsjRol.push("Ingrese Rol");

          if (this.errorMostrarMsjRol.length) this.errorRol = 1;

          return this.errorRol;
        },
        abrirModal(modelo, accion, data = []){
          switch(modelo){
            case "rol":
            {
              switch(accion){
                case 'registrar':{
                  this.modal = 1;
                  this.tituloModal = 'Registrar rol';
                  this.rol='';
                  this.tipoAccion = 1;
                  break;
                }
                case 'actualizar':{
                  this.modal=1;
                  this.tituloModal='Actualizar rol';
                  this.tipoAccion=2;
                  this.rol_id=data['id'];
                  this.rol = data['rol'];
                  break;
                }
              }
            }
          }
        },
        cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.rol_id=0;
                this.rol='';
                this.errorRol=0;
                this.tipoAccion=0;

        },

      },
      mounted() {
        this.listarRol(1,this.buscar,this.criterio);
      }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        width: 100% !important;
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #5347477a !important;
        
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
