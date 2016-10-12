;(function() 
{
	"use strict";

	angular.module("app.usuarios", [])

	.controller("UsuariosController", ["$scope", "$filter", "$http", "$modal", "$interval", function($scope, $filter, $http, $modal, $timeout) 
	{	
		// Variables de DataTable
		$scope.datas = [];
		$scope.currentPageStores = [];
		$scope.searchKeywords = "";
		$scope.filteredData = [];	
		$scope.row = "";
		$scope.numPerPageOpts = [5, 10, 25, 50, 100];
		$scope.numPerPage = $scope.numPerPageOpts[1];
		$scope.currentPage = 1;

		// Variables de Toast
		$scope.positionModel = "topRight";
		$scope.toasts = [];

		var modal;

		$scope.LlenarTabla = function()
		{
			$http({
				method: 'GET',
			  	url: 	'../ws/usuarios'
			})
			.then(function successCallback(response) 
			{
			    $scope.datas = response.data.records;
				$scope.search();
				$scope.select($scope.currentPage);
			}, 
			function errorCallback(response) 
			{			
			   console.log( response.data.message );
			});
		}

		// FUNCIONES DE DATATABLE
		$scope.select = function(page) 
		{
			var start = (page - 1)*$scope.numPerPage,
				end = start + $scope.numPerPage;

			$scope.currentPageStores = $scope.filteredData.slice(start, end);
		}

		$scope.onFilterChange = function() 
		{
			$scope.select(1);
			$scope.currentPage = 1;
			$scope.row = '';
		}

		$scope.onNumPerPageChange = function() 
		{
			$scope.select(1);
			$scope.currentPage = 1;
		}

		$scope.onOrderChange = function() 
		{
			$scope.select(1);
			$scope.currentPage = 1;
		}

		$scope.search = function() 
		{
			$scope.filteredData = $filter("filter")($scope.datas, $scope.searchKeywords);
			$scope.onFilterChange();		
		}

		$scope.order = function(rowName) 
		{
			if($scope.row == rowName)
				return;
			$scope.row = rowName;
			$scope.filteredData = $filter('orderBy')($scope.datas, rowName);
			$scope.onOrderChange();
		}	

		$scope.LlenarTabla();

		// Función para Toast
		$scope.createToast = function(tipo, mensaje) 
		{
			$scope.toasts.push(
			{
				anim: "bouncyflip",
				type: tipo,
				msg: mensaje
			});
		}

		$scope.closeAlert = function(index) 
		{
			$scope.toasts.splice(index, 1);
		}

		$scope.saveData = function( item )
		{
			if(  $scope.accion == 'crear' )
			{
				$http(
				{
					method: 'POST',
				  	url: 	'../ws/usuarios',
				  	data: 	{ 
				  		user: item.user,
				  		password: item.password,
				  		nombre: item.nombre,
				  		usuario_tipo_id: item.usuario_tipo_id
				  	}
				})
				.then(function successCallback(response) 
				{
				    $scope.LlenarTabla();
				    modal.close();
				    $scope.createToast("success", "<strong>Éxito: </strong>"+response.data.message);
				    $timeout( function(){ $scope.closeAlert(0); }, 3000);
				}, 
				function errorCallback(response) 
				{
				   console.log( response.data.message );
				});
			}
		}

		// Funciones para Modales
		$scope.modalCreateOpen = function() 
		{
			$scope.item = { usuario_tipo_id: 0 };
			$scope.opciones = [];
			$scope.accion = 'crear';

			$http.get("../ws/tipos/usuarios", {}).then(function(response)
			{
				$scope.opciones = response.data.records;
			});

			modal = $modal.open({
				templateUrl: "views/usuarios/modal.html",
				scope: $scope,
				size: "md",
				resolve: function() {},
				windowClass: "default"
			});
		}

		$scope.modalEditOpen = function(data) 
		{
			$scope.opciones = [];
			$scope.accion = 'editar';

			$http.get("../ws/tipos/usuarios", {}).then(function(response)
			{
				$scope.opciones = response.data.records;
			});

			$scope.item = data;
			modal = $modal.open({
				templateUrl: "views/usuarios/modal.html",
				scope: $scope,
				size: "md",
				resolve: function() {},
				windowClass: "default"
			});
		}

		$scope.modalClose = function() {
			modal.close();
		}
	}])
}())