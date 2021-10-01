<template>

  <div id="content-wrapper">

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Gestionar</a>
          </li>
          <li class="breadcrumb-item active">Sedes</li>
        </ol>

        <!-- Datos en tablas -->
        <div class="card mb-3">

          <div class="card-header">
            <i class="fas fa-table"></i>
            Todas las sedes
            <button type="button" @click="abrirModal('sede','registrar')" class="btn btn-primary">
              <i class="fas fa-plus-square"></i>&nbsp;Nuevo
            </button>
          </div>

          <div class="card-body">

            <div class="form-group row">
              <div class="col-md-8">
                <div class="input-group">
                  <select class="form-control col-md-4" v-model="criterio">
                  <option value="sede">Sede</option>
                  
                  </select>
                  <input type="text" v-model="buscar" @keyup.enter="listarSede(1,buscar,criterio)" class="form-control" placeholder="Buscar Sede">
                  <button type="submit" @click="listarSede(1,buscar,criterio)" class="btn btn-primary"><i class="fas fa-search-location"></i> Buscar</button>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr class="table-secondary">
                    <th>Opciones</th>
                    <th>Sede</th>
                  </tr>
                </thead>
                
                <tbody>
                  <tr v-for="sede in arraySede" :key="sede.id">
                    <td>
                      <button type="button" @click="abrirModal('sede','actualizar',sede)" class="btn btn-warning btn-sm" >
                        <i class="fas fa-pen"></i>
                      </button>
                    </td>
                    <td v-text="sede.sede"></td>
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
                      <label class="col-md-3 form-control-label" for="text-input">Sede</label>
                    <div class="col-md-9">
                      <input type="text" v-model="sede" class="form-control" placeholder="Lugar o sede">                                        
                    </div>
                  </div>
                       
                  <div v-show="errorSede" class="form-group row div-error">
                    <div class="text-center text-error">
                      <div v-for="error in errorMostrarMsjSede" :key="error" v-text="error">
                      </div>
                    </div>
                  </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                  <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarSede()">Guardar</button>
                  <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarSede()">Actualizar</button>
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
          sede_id:0,
          sede:'',
          arraySede:[],
          modal : 0,
          tituloModal : '',
          tipoAccion : 0,
          errorSede : 0,
          errorMostrarMsjSede : [],
          pagination : {
            'total' : 0,
            'current_page' : 0,
            'per_page' : 0,
            'last_page' : 0,
            'from' : 0,
            'to' : 0,
          },
          offset : 3,
          criterio : 'sede',
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
        listarSede (page,buscar,criterio){
          let me=this;
          var url='/sede?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
          axios.get(url).then(function (response) {
            var respuesta= response.data;
            me.arraySede = respuesta.sedes.data;
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
          me.listarSede(page,buscar,criterio);
        },
        registrarSede(){
          let me = this;
          if (me.validarSede()){
              return;
          }
          
          axios.post('/sede/registrar',{
              'sede': me.sede,
          }).then(function (response) {
              me.cerrarModal();
              me.listarSede(1,'','sede');
          }).catch(function (error) {
              console.log(error);
          });
        },
        actualizarSede(){
          let me = this;
          if (me.validarSede()){
              return;
          }
          axios.put('/sede/actualizar',{
            'sede': this.sede,
            'id': me.sede_id,
          }).then(function (response) {
              me.cerrarModal();
              me.listarSede(1,'','sede');
          }).catch(function (error) {
              console.log(error);
          }); 
        },
        validarSede(){
          this.errorSede=0;
          this.errorMostrarMsjSede =[];

          if (!this.sede) this.errorMostrarMsjSede.push("Ingrese sede");

          if (this.errorMostrarMsjSede.length) this.errorSede = 1;

          return this.errorSede;
        },
        abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "sede":
                    {
                        switch(accion){
                            case 'registrar':{
                                this.modal = 1;
                                this.tituloModal = 'Registrar sede';
                                this.sede='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':{
                                this.modal=1;
                                this.tituloModal='Actualizar sede';
                                this.tipoAccion=2;
                                this.sede_id=data['id'];
                                this.sede = data['sede'];
                                break;
                            }
                        }
                    }
                }

        },
        cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.sede_id=0;
                this.sede='';
                this.errorSede=0;
                this.tipoAccion=0;

        },

      },
      mounted() {
        this.listarSede(1,this.buscar,this.criterio);
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
