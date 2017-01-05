;(function() 
{
	"use strict";

	angular.module("app.creditos", ["app.constants"])

	.controller("CreditosController", ["$scope", "$filter", "$http", "$modal", "$interval", "API_URL", function($scope, $filter, $http, $modal, $timeout, API_URL)  {	
		$scope.positionModel = "topRight";
		$scope.detalle_cliente = {};
		$scope.toasts = [];

		$scope.createToast = function(tipo, mensaje) {
			$scope.toasts.push({
				anim: "bouncyflip",
				type: tipo,
				msg: mensaje
			});
		}

		$scope.closeAlert = function(index) {
			$scope.toasts.splice(index, 1);
		}

		$scope.validarCliente = function(cliente){
			$http({
				method: 'GET',
			  	url: 	API_URL+'buscarcliente',
			  	params: cliente
			})
			.then(function successCallback(response) {
				if (response.data.result) {
					$('#row-detalle').removeClass('hidden');
					$scope.detalle_cliente = response.data.records;
					$scope.detalle_cliente.nombre = response.data.records.nombre+' '+response.data.records.apellido;
					
					// Obtiene y da formato a la fecha de inicio
					var fecha_inicio = $filter('date')(new Date(),'dd-MM-yyyy');
					$scope.detalle_cliente.fecha_inicio = fecha_inicio;

					// Calcula y da formato a la fecha fin
					var fecha_fin = new Date();
					var numberOfDaysToAdd = 1;
					fecha_fin.setDate(fecha_fin.getDate() + numberOfDaysToAdd); 
				  	$scope.detalle_cliente.fecha_fin = $filter('date')(fecha_fin,'dd-MM-yyyy');

				    $scope.createToast("success", "<strong>Éxito: </strong>"+response.data.message);
				    $timeout( function(){ $scope.closeAlert(0); }, 5000);
				}
				else {
					console.log(response.data)
					$scope.createToast("danger", "<strong>Error: </strong>"+response.data.message);
				    $timeout( function(){ $scope.closeAlert(0); }, 5000);	
				}
			}, 
			function errorCallback(response) {
			   console.log(response);
			});
		};
	}])
}())