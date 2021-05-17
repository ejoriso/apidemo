<!--
 * User: oscar.merino
 * Date: 6/6/2018
 * Time: 5:09 PM
 -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title></title>
    <style type="text/css">
        body {
            font-size: 12px;
            margin:5px;

        }
         #footer {
            font-size: 12px;
            position: fixed;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 0;
            text-align: center;
        }
        div.panel-body{
              border-width: 1px;
            border-style: solid;
             border-color: #323952;
        }
         div.panel-heading{
              border-width: 1px;
             border-style: solid;
             border-color: #323952;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 0;
        }
        table.formulario thead, tr, td {
            border: 1px solid #ddd;
            padding: 5px !important;
        }
        table.formulario{
            width: 95%;
            margin-left: 20px;
            margin-top: 10px;
            border: 1px solid #ddd;
        }
        table.formulario2 thead, tr, td {
            border: 1px solid #ddd;
            padding: 5px !important;
        }
        table.formulario2{
            width: 98%;
            margin-left: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
        }
        hr{
            border: 1px solid #ddd;
            width: 92%;
            margin-left:28px;
        }
         div.panel-body2{
              border-width: 1px;
            border-style: solid;
             border-color: #323952;
               width: 92%;
             margin-left: 25px;
        }
         div.panel-heading2{
             width: 92%;
             margin-left: 25px;
             border-width: 1px;
             border-style: solid;
             border-color: #323952;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 0;
        }




    </style>
</head>
<body>
<header>
    <table class="cabecera" style="width:100%; border-collapse: collapse;">
        <tbody>
            <tr>
                <th>{{date('d/m/Y')}}</th>
                <th> </th>
            </tr>
        <tr>
            <th style="width:15%;">

                    <img id="escudo" src="{{ url('img/logoReceta.png') }}"/>
            </th>
            <th>
                {{$nombreProf}}
            </th>
        </tr>
        </tbody>
    </table>
</header>
<div class="panel-heading" >
    <div style="padding:0px !important;">&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;RECETA</div>
 </div>
 <div class="panel-body">
      <table class="formulario" cellpadding="0" cellspacing="0"  cellspacing="">
      <tr>
          <td style="width:10% !important;text-align:left!important; background-color: #eee;"><b>Receta #</b></td>
          <td> {{$receta->idReceta}}</td>
      </tr>
     <tr>
          <td style="width:10% !important;text-align:left!important; background-color: #eee;"><b>Fecha emisión</b></td>
          <td>{{date('d-m-Y',strtotime($receta->fechaEmision))}}</td>
      </tr>
        <tr>
          <td style="width:20% !important;text-align:left!important; background-color: #eee;"><b>JVPM médico</b></td>
          <td>{{$jvpm}}</td>
      </tr>
      <tr>
          <td style="width:20% !important;text-align:left!important; background-color: #eee;"><b>Tipo de uso </b></td>
          <td>{{$receta->nomTipoUso}}</td>
      </tr>
    </table>
     <br>
     <hr><br>
    @if($receta->tipoUso==2)
          <table class="formulario" cellpadding="0" cellspacing="0">
            <caption>DATOS DEL PROFESIONAL</caption>
            <tr>
                <td style="width:15% !important;text-align:left!important; background-color: #eee;"><b>Nombre <i class="fa fa-search"></i></b></td>
                <td>{{$nombreProf}}</td>
            </tr>
             <tr>
                <td style="width:10% !important;text-align:left!important; background-color: #eee;"><b>JVPM</b></td>
                <td>{{$jvpm}}</td>
            </tr>
              <tr>
                <td style="width:10% !important;text-align:left!important; background-color: #eee;"><b>DUI</b></td>
                <td>{{$duiProf}}</td>
            </tr>
          </table>
    @else
          @if($receta->tipoUso==3)
                   <table class="formulario" cellpadding="0" cellspacing="0">
                  <caption>DATOS DEL MENOR DE EDAD</caption>
                  <tr>
                      <td style="width:15% !important;text-align:left!important; background-color: #eee;"><b>Nombre </b></td>
                      <td>{{$receta->nomMenor}}</td>
                  </tr>
                </table>
                <br>
          @endif
          <table class="formulario" cellpadding="0" cellspacing="0">
            <caption>{{$receta->tipoUso==1?'DATOS DEL PACIENTE':'DATOS PERSONA RESPONSABLE'}}</caption>
            <tr>
                <td style="width:15% !important;text-align:left!important; background-color: #eee;"><b># Documento <i class="fa fa-search"></i></b></td>
                <td>{{$receta->idPaciente}}</td>
            </tr>
             <tr>
                <td style="width:10% !important;text-align:left!important; background-color: #eee;"><b>{{$receta->tipoUso==1?'Paciente':'Persona responsable'}}</b></td>
                <td>{{$receta->paciente}}</td>
            </tr>
              <tr>
                <td style="width:10% !important;text-align:left!important; background-color: #eee;"><b>Dirección</b></td>
                <td>{{$receta->domicilioPaciente}}</td>
            </tr>
          </table>

    @endif
    <br>
    <hr><br>

    <table class="formulario" cellpadding="0" cellspacing="0">
      <tr>
          <td style="width:150px !important;text-align:left!important; background-color: #eee;"><b>Producto controlado</b></td>
          <td>{{$receta->idProducto}}</td>
      </tr>
       <tr>
          <td style="width:10% !important;text-align:left!important; background-color: #eee;"><b>Nombre comercial</b></td>
          <td>{{$receta->nombreProducto}}</td>
      </tr>
    </table>
    <br>
    <hr><br>
    <div class="panel-heading2" >
        <div style="padding:0px !important;">&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;DATOS SOBRE DOSIS</div>
     </div>
     <div class="panel-body2">
     @if($receta->tipoUso==2)
          <table  class="formulario2" cellpadding="0" cellspacing="0">
                       <tr>
                          <td style="width:140px !important;text-align:left!important; background-color: #eee;"><b>Cantidad total de medicamento a adquirir</b></td>
                          <td>{{$receta->magPrescripcion}}</td>
                      </tr>

          </table>
     @else
           <table  class="formulario2" cellpadding="0" cellspacing="0">
                         <tr>
                            <td style="width:140px !important;text-align:left!important; background-color: #eee;"><b>Total dosis prescrita</b></td>
                            <td>{{$receta->magPrescripcion}}</td>
                        </tr>
                         <tr>
                            <td style="width:140px !important;text-align:left!important; background-color: #eee;"><b>Dosis según receta</b></td>
                            <td>{{$receta->descPrescripcion}}</td>
                        </tr>
                        <tr>
                            <td style="width:140px!important;text-align:left!important; background-color: #eee;"><b>Total de tomas por ciclo</b></td>
                            <td>{{$receta->dosisCiclo}}</td>
                        </tr>
                          <tr>
                            <td style="width:140px!important;text-align:left!important; background-color: #eee;"><b>Ciclo de dosis</b></td>
                            <td> @if($receta->dosisCiclo==2) 24 Horas @else 12 Horas @endif</td>
                        </tr>
                          <tr>
                            <td style="width:140px !important;text-align:left!important; background-color: #eee; "><b>Duración tratamiento</b></td>
                            <td>{{$receta->duracionTratamiento}} Días</td>
                        </tr>
            </table>
        @endif
     <br>
     </div>
    <br>
</div>

<footer id="footer">
   <!-- © {{date('Y')}} Dirección Nacional de Medicamentos (medicamentos.gob.sv) Diseñado por IT DNM-->
    <!--Blv. Merliot y Av. Jayaque, Edif. DNM, Urb. Jardines del Volcán, Santa Tecla, La Libertad, El Salvador, América
    Central.&nbsp;&nbsp; PBX 2522-5000 / web: www.medicamentos.gob.sv-->
</footer>

</body>

</html>