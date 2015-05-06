

	var qdivCamposHistorico = 0;
	var qdivCamposOutrosLotes = 0;
	var qdivCamposRestricoes = 0;
	var qdivCamposServicos = 0;
	var qdivCamposServicos2 = 5;
	var qdivCamposRestricoes = 0;
	var qdivCamposProcessos = 0;
	var qdivCamposAdicionais = 0;
  var qdivCamposTarefas= 2;
  var qdivCamposIncorporacao = 0;

/*********************************************************************************************/
/*      						 Cria campos para o Histórico					             */
/*                                                                                           */
/*********************************************************************************************/
	
    function criarCampoHistorico(){
	    
		var objPai = document.getElementById("DivHistoricoOrigem");
		//Criando o elemento DIV;
		var objFilho = document.createElement("DivHistoricoDestino");
		//Definindo atributos ao objFilho:
		objFilho.setAttribute("id","Historico"+qdivCamposHistorico);
		
		//Inserindo o elemento no pai:
		objPai.appendChild(objFilho);
		//Escrevendo algo no filho recem-criado:
		document.getElementById("Historico"+qdivCamposHistorico).innerHTML =
					
		"<div class='col-md-3'>"
        +"<input name='SqlHistoricoArray[]' id='SqlHistoricoArray["+qdivCamposHistorico+"]' type='text'  class='form-control' placeholder='SQL'>"
        +"</div>"
        +"<div class='col-md-2'>"
        +" <input name='DataHistoricoArray[]' id='DataHistoricoArray["+qdivCamposHistorico+"]' type='text' maxlength='4' class='form-control' placeholder='Data (ano)'>"
        +"</div>"
        +"<div class='col-md-3'>"
        +"<input name='AreaTerrenoHistoricoArray[]' id='AreaTerrenoHistoricoArray["+qdivCamposHistorico+"]' type='text'  class='form-control' placeholder='Area do terreno (m2)'>"
         +"</div>"
         +"<div class='col-md-2'>"
         +"<input name='AreaEdificadaHistoricoArray[]' id='AreaEdificadaHistoricoArray["+qdivCamposHistorico+"]' type='text'  class='form-control' placeholder='Area edificada(m2)'>"
        +"</div>"
        +"<div class='col-md-2'>"        
        +"<select name='SituacaoHistoricoArray[]' id='SituacaoHistoricoArray["+qdivCamposHistorico+"]' class=' form-control'  >"
        +"<option>Regular</option>"
        +"<option>Irregular</option>"
           +"</select>"  
           +"</div>"
           qdivCamposHistorico++;
}
  
 /*********************************************************************************************/
/*      						 Cria campos para o Outros Lotes				                                 */
/*                                                                                           */
/*********************************************************************************************/
      function criarCampoOutrosLotes(){
	    
		var objPai = document.getElementById("divOutrosLotesOrigem");
		//Criando o elemento DIV;
		var objFilho = document.createElement("divOutrosLotesDestino");
		//Definindo atributos ao objFilho:
		objFilho.setAttribute("id","OutrosLotes"+qdivCamposOutrosLotes);
		
		//Inserindo o elemento no pai:
		objPai.appendChild(objFilho);
		//Escrevendo algo no filho recŽm-criado:
		document.getElementById("OutrosLotes"+qdivCamposOutrosLotes).innerHTML =
				  "<div class='col-md-3'>"
				  +"<input name='SqlOutrosLotesArray[]' id='SqlOutrosLotesArray["+qdivCamposOutrosLotes+"]' type='text'  class='form-control' placeholder='SQL'>"
				  +" </div>"
				  +" <div class='col-md-2'>"
				  +" <input name='AreaTerrenoOutrosLotesArray[]' id='AreaTerrenoOutrosLotesArray["+qdivCamposOutrosLotes+"]' type='text'  class='form-control' placeholder='Area do Terreno(m2)'>"
	                      +"</div>"
	                      +"<div class='col-md-2'>"
	                      +" <input name='AreaConstruidaOutrosLotesArray[]' id='AreaConstruidaOutrosLotesArray["+qdivCamposOutrosLotes+"]' type='text'  class='form-control' placeholder='Area Construida(m2)'>"
				  +"</div>"
				  +"  <div class='col-md-2'>"
				  +"  <input name='TestadaoutrosLotesArray[]' id='TestadaoutrosLotesArray["+qdivCamposOutrosLotes+"]' type='text'  class='form-control' placeholder='Testada'>"
				  +" </div>"
				  +" <div class='col-md-2'>"
				  +" <input name='MatriculaOutrosLotesArray[]' id='MatriculaOutrosLotesArray["+qdivCamposOutrosLotes+"]' type='text'  class='form-control' placeholder='Matricula'>"
				  +"</div>";
		qdivCamposOutrosLotes++;
}



   
            /*********************************************************************************************/
            /*      						 Cria campos para Processos						             */
            /*                                                                                           */
            /*********************************************************************************************/
                  function criarCampoProcessos(){
            	    
            		var objPai = document.getElementById("divProcessosOrigem");
            		//Criando o elemento DIV;
            		var objFilho = document.createElement("divProcessosDestino");
            		//Definindo atributos ao objFilho:
            		objFilho.setAttribute("id","Processos"+qdivCamposProcessos);
            		
            		//Inserindo o elemento no pai:
            		objPai.appendChild(objFilho);
            		//Escrevendo algo no filho recŽm-criado:
            		document.getElementById("Processos"+qdivCamposProcessos).innerHTML =
            				  "<div class='col-md-3'>"
            				  +"<input name='AnoProcessoProcessoArray[]' id='AnoProcessoProcessoArray["+qdivCamposProcessos+"]' maxlength='4' type='text'  class='form-control' placeholder='Ano/Processo'>"
            				  +" </div>"
            				  +" <div class='col-md-3'>"
            				  +" <input name='InteressadoProcessoArray[]' id='InteressadoProcessoArray["+qdivCamposProcessos+"]' type='text'  class='form-control' placeholder='Interessado'>"
            	                      +"</div>"
            	                      +"<div class='col-md-3'>"
            	                      +" <input name='AssuntoProcessoArray[]' id='AssuntoProcessoArray["+qdivCamposProcessos+"]' type='text'  class='form-control' placeholder='Assunto'>"
            				  +"</div>"
            				  +"  <div class='col-md-3'>"
            				  +"  <input name='SituacaoProcessoArray[]' id='SituacaoProcessoArray["+qdivCamposProcessos+"]' type='text'  class='form-control' placeholder='Situação'>"
            				  +" </div>";            				
            		qdivCamposProcessos++;
        }
                  
   
                  
                  
                  /*********************************************************************************************/
                  /*      						 Cria campos para Processos				    		                                */
                  /*                                                                                           */
                  /*********************************************************************************************/
                        function criarCampoAdicionais(){
                  	    
                  		var objPai = document.getElementById("divAdicionaisOrigem");
                  		//Criando o elemento DIV;
                  		var objFilho = document.createElement("divAdicionaisDestino");
                  		//Definindo atributos ao objFilho:
                  		objFilho.setAttribute("id","Adicionais"+qdivCamposAdicionais);
                  		
                  		//Inserindo o elemento no pai:
                  		objPai.appendChild(objFilho);
                  		//Escrevendo algo no filho recŽm-criado:
                  		document.getElementById("Adicionais"+qdivCamposAdicionais).innerHTML =
                  				 "<div class='col-md-3'>"
                  				+"<input name='TituloDadosAdicionaisArray[]' id='TituloDadosAdicionaisArray["+qdivCamposAdicionais+"]' type='text'  class='form-control' placeholder='Titulo'>"	
                  				+"</div>"
                  				+"<div class='col-md-9'>"
                  				+"<input name='ComentariosDadosAdicionaisArray[]' id='ComentariosDadosAdicionaisArray["+qdivCamposAdicionais+"]' type='text'  class='form-control' placeholder='Comentário'>"	
                  				+"</div>";                  				           				
                  		qdivCamposAdicionais++;
              }
      
                        
                        
/*********************************************************************************************/
/*      						 Cria campos para os Serviços					             */
/*                                                                                           */
/*********************************************************************************************/
      function criarCampoServicos(){
	    
		var objPai = document.getElementById("DivServicosOrigem");
		//Criando o elemento DIV;
		var objFilho = document.createElement("DivServicosDestino");
		//Definindo atributos ao objFilho:
		objFilho.setAttribute("id","Servicos"+qdivCamposServicos);
		
		//Inserindo o elemento no pai:
		objPai.appendChild(objFilho);
		//Escrevendo algo no filho recŽm-criado:
		document.getElementById("Servicos"+qdivCamposServicos).innerHTML =
				  "<div class='col-md-12'>"
                    +"<input name='DocumentoArray[]' id='DocumentoArray"+qdivCamposServicos+"' type='text'  class='form-control' placeholder='Documento'>"
                    +"</div>";
		qdivCamposServicos++;
}

//Função para remover elemento
    function removerCampo(id) {
    var objPai = document.getElementById("DivServicosOrigem");
    var objFilho = document.getElementById("Servicos"+id);
      
    //Removendo o DIV com id espec’fico do n—-pai:
    var removido = objPai.removeChild(objFilho);
    objPai.removeChild(objFilho);
    objPai.appendChild(objFilho);
}

/*********************************************************************************************/
/*      						 Cria campos para os Serviços					             */
/*                                                                                           */
/*********************************************************************************************/
      function criarCampoServicos2(){
	    
		var objPai = document.getElementById("DivServicos2Origem");
		//Criando o elemento DIV;
		var objFilho = document.createElement("DivServicos2Destino");
		//Definindo atributos ao objFilho:
		objFilho.setAttribute("id","Servicos2"+qdivCamposServicos2);
		
		//Inserindo o elemento no pai:
		objPai.appendChild(objFilho);
		//Escrevendo algo no filho recŽm-criado:
		document.getElementById("Servicos2"+qdivCamposServicos2).innerHTML =
				             "<div class='col-md-8'>"
                         +"<label class='form-label'>Serviço "+qdivCamposServicos2+"</label>"
                          +"<select name='SelectServicoArray[]' id='SelectServicoArray["+qdivCamposServicos2+"]' class='select2 form-control' >"
                          +"<option value='Selecionar...'>Selecionar...</option>"                             
                          +"</select>"
                           +"</div>"
                       +"<div class='col-md-4'>"
                          +"<label class='form-label'>Valor</label>"
                          +"<input name='ValorArray[]' id='ValorArray' type='text' value='0' class='form-control' placeholder='R$ 8.000,00' onkeypress='verificaNumerosCalculo();'>"
                      +"</div>";
                    qdivCamposServicos2++;
}


/************************************************************   *********************************/
/*                      Cria campos para os TAREFAS                                            */
/*                                                                                            */
/*********************************************************************************************/
      function criarCampoTarefa(){
      
    var objPai = document.getElementById("DivTarefasOrigem");
    //Criando o elemento DIV;
    var objFilho = document.createElement("DivTarefasDestino");
    //Definindo atributos ao objFilho:
    objFilho.setAttribute("id","Tarefas"+qdivCamposTarefas);
    
    //Inserindo o elemento no pai:
    objPai.appendChild(objFilho);
    //Escrevendo algo no filho recŽm-criado:
    document.getElementById("Tarefas"+qdivCamposTarefas).innerHTML = 
                     "<div class='row form-row'>"
                    +"<div class='col-md-12'>"
                     +"<h4>Tarefa "+qdivCamposTarefas+" </h4>"
                    +"</div>"
                   +" </div>"                   
                    +"<div class='row form-row' >"
                    +"<div class='col-md-2'>"
                        +"<select name = 'SelectUsuarioArray[]' id='SelectUsuarioArray[]' style='width:100%'>"                
                    +"<option value='1'>Responsável</option>"                 
                  +"</select>"
                      +"</div> "                     
                      +"<div class='col-md-2'>"
                        +"<input name='TituloArray[]' id='TituloArray[]' type='text'  class='form-control' placeholder='Titulo '>"
                      +"</div>"
                      +"<div class='col-md-6'>"
                        +"<input name='DescricaoArray[]' id='DescricaoArray[]' type='text'  class='form-control' placeholder='Descrição '>"
                      +"</div>"
                      +"<div class='col-md-2'>"
                        +"<input name='DataEntregaArray[]' id='DataEntregaArray[]' type='text'  class='form-control date' placeholder='Data entrega '>"
                     +"</div'"                     
                    +"</div>";
                    qdivCamposTarefas++;

}


/*********************************************************************************************/
/*                   Cria campos para os Hisórico Incorporação                               */
/*                                                                                           */
/*********************************************************************************************/
      function criarCampoIncorporacao(){
      
    var objPai = document.getElementById("DivIncorporacaoOrigem");
    //Criando o elemento DIV;
    var objFilho = document.createElement("DivIncorporacaoDestino");
    //Definindo atributos ao objFilho:
    objFilho.setAttribute("id","Incorporacao"+qdivCamposIncorporacao);
    
    //Inserindo o elemento no pai:
    objPai.appendChild(objFilho);
    //Escrevendo algo no filho recŽm-criado:
    document.getElementById("Incorporacao"+qdivCamposIncorporacao).innerHTML =
                         "<div class='col-md-3'>"     
                              +"<input name='DataArray[]' id='DataArray[]' type='text'  class='form-control' placeholder='Data'>"
                            +"</div>"
                            +"<div class='col-md-9'>"                         
                              +"<input name='DescricaoArray[]' id='DescricaoArray["+qdivCamposIncorporacao+"]' type='text'  class='form-control' placeholder='Descrição'>"
                            +"</div>";
                    qdivCamposIncorporacao++;
}