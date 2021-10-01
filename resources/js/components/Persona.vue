<template>

  <div id="content-wrapper">

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Gestionar</a>
          </li>
          <li class="breadcrumb-item active">Pagos Fijos</li>
        </ol>

        <!-- Datos en tablas -->
        <div class="card mb-3">

          <div class="card-header">
            <i class="fas fa-table"></i>
            Todos los pagos mensuales fijos 
            <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-primary">
              <i class="fas fa-plus-square"></i>&nbsp;Nuevo
            </button>
          </div>

          <div class="card-body">

            <div class="form-group row">
              <div class="col-md-8">
                <div class="input-group">
                  <select class="form-control col-md-4" v-model="criterio">
                  <option value="nombres">Nombre</option>
                  <option value="celular">Celular</option>
                  </select>
                  <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="alquiler de techo">
                  <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fas fa-search-location"></i> Buscar</button>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr class="table-secondary">
                    <th>Opciones</th>
                    <th>Nombres de los pagos</th>
                    <th>Celular</th>
                    <th>Fecha de registro</th>
                    <th>Fecha de cobros/pagos</th>
                    <th>Monto mensual (S/.)</th>
                  </tr>
                </thead>
                
                <tbody>
                  <tr v-for="persona in arrayPersona" :key="persona.id">
                    <td>
                      <button type="button" @click="abrirModal('persona','actualizar',persona)" class="btn btn-warning btn-sm" >
                        <i class="fas fa-pen"></i>
                      </button>
                      
                    </td>
                    <td v-text="persona.nombres"></td>
                    <td v-text="persona.celular"></td>
                    <td v-text="persona.fecha_registro"></td>
                    <td v-text="persona.fecha_cobros_pagos"></td>
                    <td v-text="persona.monto_mensual"></td>
                    
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
                      <label class="col-md-3 form-control-label" for="text-input">Nombres de los pagos</label>
                    <div class="col-md-9">
                      <input type="text" v-model="nombres" class="form-control" placeholder="Alquiler">                                        
                    </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="text-input">Celular</label>
                    <div class="col-md-9">
                      <input type="text" v-model="celular" class="form-control" placeholder="987654321">                                        
                    </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="text-input">Fecha de registro</label>
                    <div class="col-md-9">
                      <input type="text" v-model="fecha_registro" class="form-control" placeholder="Alquiler">                                        
                    </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="text-input">Fecha de cobro/pago</label>
                    <div class="col-md-9">
                      <input type="text" v-model="fecha_cobros_pagos" class="form-control" placeholder="Alquiler">                                        
                    </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="text-input">Monto mensual</label>
                    <div class="col-md-9">
                      <input type="text" v-model="monto_mensual" class="form-control" placeholder="Alquiler">                                        
                    </div>
                  </div>
                       
                  <div v-show="errorPersona" class="form-group row div-error">
                    <div class="text-center text-error">
                      <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">
                      </div>
                    </div>
                  </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                  <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                  <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
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
          persona_id:0,
          nombres:'',
          celular:'',
          fecha_registro:null,
          fehca_cobros_pagos:'',
          monto_mensual:0.0,
          arrayPersona:[],
          modal : 0,
          tituloModal : '',
          tipoAccion : 0,
          errorPersona : 0,
          errorMostrarMsjPersona : [],
          pagination : {
            'total' : 0,
            'current_page' : 0,
            'per_page' : 0,
            'last_page' : 0,
            'from' : 0,
            'to' : 0,
          },
          offset : 3,
          criterio : 'nombres',
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
        listarPersona (page,buscar,criterio){
          let me=this;
          var url='/persona?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
          axios.get(url).then(function (response) {
            var respuesta= response.data;
            me.arrayPersona = respuesta.personas.data;
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
          me.listarPersona(page,buscar,criterio);
        },
        registrarPersona(){
          let me = this;
          if (me.validarPersona()){
              return;
          }
          
          axios.post('/persona/registrar',{
              'nombres': me.nombres,
              'celular': me.celular,
              'fecha_registro': me.fecha_registro,
              'fecha_cobros_pagos': me.fecha_cobros_pagos,
              'monto_mensual': me.monto_mensual,
          }).then(function (response) {
              me.cerrarModal();
              me.listarPersona(1,'','nombres');
          }).catch(function (error) {
              console.log(error);
          });
        },
        actualizarPersona(){
          let me = this;
          if (me.validarPersona()){
              return;
          }
          axios.put('/persona/actualizar',{
            'nombres': me.nombres,
            'celular': me.celular,
            'fecha_registro': me.fecha_registro,
            'fecha_cobros_pagos': me.fecha_cobros_pagos,
            'monto_mensual': me.monto_mensual,
            'id': me.persona_id,
          }).then(function (response) {
              me.cerrarModal();
              me.listarPersona(1,'','nombres');
          }).catch(function (error) {
              console.log(error);
          }); 
        },
        
        validarPersona(){
          this.errorPersona=0;
          this.errorMostrarMsjPersona =[];

          if (!this.nombres) this.errorMostrarMsjPersona.push("Ingrese un nombre del pago");
          if (!this.fecha_cobros_pagos) this.errorMostrarMsjPersona.push("Ingrese fecha de pago");
          if (!this.monto_mensual) this.errorMostrarMsjPersona.push("Ingrese monto mensual");
          if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

          return this.errorPersona;
        },
        abrirModal(modelo, accion, data = []){
          switch(modelo){
            case "persona":
            {
              switch(accion){
                case 'registrar':{
                  this.modal = 1;
                  this.tituloModal = 'Registrar Pago Fijo';
                  this.nombres='';
                  this.celular='';
                  this.fecha_registro='';
                  this.fehca_cobros_pagos='';
                  this.monto_mensual='';
                  this.tipoAccion = 1;
                  break;
                }
                case 'actualizar':{
                  this.modal=1;
                  this.tituloModal='Actualizar Pago Fijo';
                  this.tipoAccion=2;
                  this.persona_id=data['id'];
                  this.nombres = data['nombres'];
                  this.celular = data['celular'];
                  this.fecha_registro = data['fecha_registro'];
                  this.fecha_cobros_pagos = data['fecha_cobros_pagos'];
                  this.monto_mensual = data['monto_mensual'];
                  break;
                }
              }
            }
          }
        },
        cerrarModal(){
          this.modal=0;
          this.tituloModal='';
          this.persona_id=0;
          this.nombres='';
          this.celular='';
          this.fecha_registro='';
          this.fehca_cobros_pagos='';
          this.monto_mensual='';
          this.errorPersona=0;
          this.tipoAccion=0;

        },

      },
      mounted() {
        this.listarPersona(1,this.buscar,this.criterio);
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
