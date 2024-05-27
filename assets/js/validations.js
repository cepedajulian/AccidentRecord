function FormValidator(){

// USER ---------------------------------------------------------------------------------			
	 $.fn.bootstrapValidator.validators.password2 = {
		        validate: function(validator, $field, options) {
		            var value = $field.val();
		            alert(value);
		            if (value === '') {
		                return true;
		            }

		            if (value.length < 8) {
		                return false;
		            }
		            if (value === value.toLowerCase()) {
		                return false;
		            }
		            if (value === value.toUpperCase()) {
		                return false;
		            }
		            if (value.search(/[0-9]/) < 0) {
		                return false;
		            }

		            return true;
		        }
		    };
	 
	$('#usersForm').bootstrapValidator({
		message: 'This value is not valid',
		fields: {
			username: {
				validators: {
					notEmpty: {
						message: 'El nombre de usuario es un dato obligatorio.'
					},
					stringLength: {
						min: 3,
						max: 20,
						message: 'El nombre de usuario debe tener entre 3 y 20 caracteres.'
					}
				}
			},
			mail: {
				validators: {
					emailAddress: {
						message: 'El formato del e-mail no es correcto'
					}
				}
			},
			password: {
				validators: {
					notEmpty: {
						message: 'El password es un campo obligatorio.'
					}
					
				},
				password2: {
                    message: 'The password is not valid'
                }
			},
			passconf: {
				validators: {
					notEmpty: {
						message: 'La confirmaci&oacute;m del password no es correcta.'
					},
					identical: {
						field: 'password',
						message: 'La confirmaci&oacute;n del password no es correcta.'
					}
				}
			}
		}
	});


	
	
	// SINIESTROS ------------------------------------------------------------
	$('#siniestrosForm').bootstrapValidator({
		message: 'No es un valor v&aacute;lido',
		fields: {
			altura: {
				validators: {	
					regexp: {
						regexp: /^[0-9_\.]+$/,
						message: 'S&oacute;lo est&aacute;n permitidos caracteres num&eacute;ricos'
					}
				}
			},
			fecha: {
				validators: {	
					notEmpty: {
						message: 'Es un dato obligatorio.'
					}
				}
			},
			hora: {
				validators: {	
					 between: {
	                        min: 0,
	                        max: 23,
	                        message: 'La hora debe ser entre 0-23'
	                    },
					notEmpty: {
						message: 'Es un dato obligatorio.'
					}
				}
			},
			min: {
				validators: {	
					 between: {
	                        min: 0,
	                        max: 59,
	                        message: 'Los minutos deben ser entre 0-59'
	                    },
					notEmpty: {
						message: 'Es un dato obligatorio.'
					}
				}
			}
//			calle1: {
//	            validators: {
//	                different: {
//	                    field: 'calle2',
//	                    message: 'Las calles no pueden ser iguales'
//	                }
//	            }
//				
//	        },
//	        calle2: {
//	            validators: {
//	                different: {
//	                    field: 'calle3',
//	                    message: 'Las calles no pueden ser iguales'
//	                }
//	            }
//	        },
//	        calle3: {
//	            validators: {
//	                different: {
//	                    field: 'calle1',
//	                    message: 'Las calles no pueden ser iguales'
//	                }
//	            }
//	        }
	      
		}
	});
	
	// VEHICULOS ------------------------------------------------------------
	$('#vehiculosForm').bootstrapValidator({
		message: 'No es un valor v&aacute;lido',
		fields: {
			anio: {
				validators: {	
					regexp: {
						regexp: /^[0-9_\.]+$/,
						message: 'S&oacute;lo est&aacute;n permitidos caracteres num&eacute;ricos'
					}
				}
			}
			
		}
	});
	
	// CIUDADES ------------------------------------------------------------
	$('#ciudadesForm').bootstrapValidator({
		message: 'This value is not valid',
		fields: {
			ciudad: {
				validators: {
					notEmpty: {
						message: 'El nombre de la ciudad es un dato obligatorio.'
					}
				}
			},
			coordenadas: {
				validators: {
					notEmpty: {
						message: 'Las coordenadas son un dato obligatorio.'
					}
				}
			},
			zoom: {
				validators: {
					notEmpty: {
						message: 'El zoom es un dato obligatorio.'
					}
				}
			},
			logo_width: {
				validators: {
					notEmpty: {
						message: 'El ancho del logo es un dato obligatorio.'
					}
				}
			}
		}
	});
	
}