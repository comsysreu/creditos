;(function() 
{
	"use strict";	
	angular.module("login", ["LocalStorageModule",
							"ngRoute",
							"ngAnimate",
							"ngSanitize",
							"ngAria",
							"ngMaterial",
							"oc.lazyLoad",
							"ui.bootstrap",
							"angular-loading-bar",
							"FBAngular",
							"app.ctrls",
							"app.directives",
							"app.ui.ctrls",
							"app.ui.directives",
							"app.form.ctrls",
							"app.table.ctrls",
							"app.email.ctrls"])

	.controller("LoginController", ["$scope", "$http", "$window", "localStorageService", function($scope, $http,$window, localStorageService) 
	{
		localStorageService.cookie.clearAll();	  
		$scope.loginUsuario = function(item) 
		{
		  	$scope.item = item;
	        $http({
	            method: "POST",
	            url: "../../ws/login",
	            data: {
	            	usuario: item.usuario,
	            	password: item.password
	            }
	        })
	        .then(function succesCallback(response){
	           	if(response.data.result){     
	           		localStorageService.cookie.set("login",response.data.records,10);	           		
	            	$window.location.href = "./#/dashboard";
	           	}
	           	else {
	            	$window.alert( response.data.message );
	            	$window.location.href = "login.html";
	           	}
		    },
		    function errorCallback(response) {
				$log.error( response );
		    })
	    }
	}])
}())