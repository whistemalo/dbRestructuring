  Public Function FinalizarVerificacionSolicitud() As Integer

        ' obtener la duracion de la tarea de la fecha
        Dim cEstatusSolicitud As New cEstatusSolicitud
        Dim EstatusSolicitud As New EstatusSolicitud

        Try
            EstatusSolicitud = cEstatusSolicitud.ObtenerEstatusSolicitud(Tipo)
            If EstatusSolicitud Is Nothing Then
                Me.AsignarMensaje("Error al Obtener Estado de la Solicitud")
                Return 0
            End If
        Catch ex As Exception
            Me.AsignarMensaje("Error al Obtener Estado de la Solicitud" + ex.Message)
            Return 0
        End Try

        Entidad = Me.ListaSolicitudCompraBindingSource.Current
        ' fecha: 24-septiembre-2012
        ' Validacion de idProceso
        ' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
        If Entidad.idProceso = Nothing Then Entidad.idProceso = -1
        If Entidad.idProceso = 0 Then Entidad.idProceso = -1

        ' fecha: 8-abril-2014
        ' Incidente:
        ' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
        If Entidad.idProcesoAdq = Nothing Then Entidad.idProcesoAdq = -1
        If Entidad.idProcesoAdq = 0 Then Entidad.idProcesoAdq = -1


        Select Case Tipo
            ' fecha: 17-agosto-2012
            ' Solicitud: 294-2012 Referencia: 6329
            ' Solicitudes de Complemento.
            ' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
            ' Case enumEstadosSolicitud.Elaborada And Entidad.idTipoEvento.ToString = "5" ' Solicitud en Elaborada y de COMPLEMENTO

            Case enumEstadosSolicitud.Elaborada '  ingreso de solicitud
                ''Fecha: 20/09/2019
                ''Sistema a publicar: Procesos Administrativos
                ''Base de datos: [Producción]
                ''Publicación requerida por: Incidente :  50388
                ''Realizar publicación: [Inmediata]
                ''Reportado Por: Eduardo Rivera
                ''Descripción:    ADECUAR EL SISTEMA PARA GENERAR PROCESOS A TRAVÉS DE BOLPROS.
                ''Realizado Por: Ivania Blanco.
                ''Aprobado Por: Eduardo Rivera.
                'If Entidad.idTipoEvento = 12 Then
                '    MessageBox.Show("Mensaje: Recuerde ingresar solicitud de comisión para este tipo de compras")
                'End If


                If ActualizarIngreso(EstatusSolicitud.duracionDias) <> 1 Then
                    Exit Function
                End If
                EnviarCorreoNotificacion(Tipo, 1, Me.cEMPL.ObtenerCodigoJefe(Me.codigoEmpleado), "")

            ' Case enumEstadosSolicitud.Analisis_Jefe_ACI
            '     If ActualizarAnalisisDeSolicitud(EstatusSolicitud.duracionDias) <> 1 Then
            '         Exit Function
            '     End If

            Case enumEstadosSolicitud.Asignacion_Tecnico ' asignar tecnico ACI
                If ActualizarAsignacionTecnicoACI(EstatusSolicitud.duracionDias) <> 1 Then
                    Exit Function
                End If

                Dim newTecnicoACI As New cTecnicoACI
                EnviarCorreoNotificacion(Tipo, 1, newTecnicoACI.ObtenerCODI_EMPLTecnicoACI(Entidad.idTecnicoACI), "")

            ' Case enumEstadosSolicitud.Verificacion_Contenido_Tec_ACI ' analisis de solicitud
            '     If ActualizarAnalisisDeSolicitud(EstatusSolicitud.duracionDias) <> 1 Then
            '         Exit Function
            '     End If
            Case enumEstadosSolicitud.Ingreso_de_Precio
                If ActualizarIngresoMonto(EstatusSolicitud.duracionDias) <> 1 Then
                    Exit Function
                End If

            Case enumEstadosSolicitud.Aprobacion_Gerencia_Solicitante

                If Entidad Is Nothing Then
                    Me.AsignarMensaje("No Puede Finalizar Sin Almacenar Cambios")
                    Return -1
                Else

                    Entidad.fhInicioEstimado = Now
                    Entidad.fhFinEstimado = Now.AddDays(EstatusSolicitud.duracionDias)
                    Entidad.fhInicio = Now
                    '' FLUJO NUEVO
                    'If Entidad.idTipoSolicitud = "5" Then
                    '    Entidad.idEstatusSolicitud = enumEstadosSolicitud.Ingreso_de_Precio
                    'Else
                    '    Entidad.idEstatusSolicitud = enumEstadosSolicitud.Verificacion_Presupuesto
                    'End If

                    ' FLUJO NUEVO PARA QUE DESPUES DE APROBAR LA UNIDAD SOLICITANTE CONTINUE DIRECTO A LA GERENCIA DE COMPRAS
                    '22/03/2022
                    ''SE AGREGA EL TIPO DE SOLICITUD 7
                    ''TICKET 11022
                    ''EDUARDO RIVERA
                    If Entidad.idTipoSolicitud = "5" Or Entidad.idTipoSolicitud = "7" Then
                        Entidad.idEstatusSolicitud = enumEstadosSolicitud.Asignacion_Tecnico
                    Else
                        Entidad.idEstatusSolicitud = enumEstadosSolicitud.Verificacion_Presupuesto
                    End If

                    'Entidad.idEstatusSolicitud = enumEstadosSolicitud.Verificacion_Presupuesto
                    Entidad.fhUltimaModificacion = Now
                    Entidad.usuarioModifica = Me.usuarioActualizacion
                    Entidad.jefeAutoriza = Me.codigoEmpleado
                    '
                    ' fecha: 20-marzo-2012
                    ' Cuando se solicitan por anticipos se cambia el estatus a "Aprobacion Gerencia Solicitante"
                    ' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                    '
                    ' fecha: 7-febrero-2014
                    ' Solicitud: 126-2014 Referencia: 8245
                    ' Se agrega el tipo de evento Solicitud de Refuerzo Complementario
                    ' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                    '
                    ' LINEA ORIGINAL
                    '
                    ' If Entidad.idTipoEvento.ToString = "5" Or Entidad.idTipoEvento.ToString = "3" Then
                    '
                    ' fecha: 7-septiembre-2015
                    ' Solicitud: 653-2015
                    ' Se cambia debido a que se envia a asignacion de tecnico aci
                    ' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                    '
                    Entidad.idTecnicoACI = -1

                    '
                    'If Entidad.idTipoEvento.ToString = "5" Or Entidad.idTipoEvento.ToString = "3" Or Entidad.idTipoEvento.ToString = "9" Or Entidad.idTipoEvento.ToString = "10" Then
                    ' ' No se valida el Tecnico ACI asignado debido a que se asigna hasta que llega al Jefe ACI
                    ' Entidad.idTecnicoACI = -1
                    'Else
                    ' If Entidad.idTecnicoACI = 0 Then
                    'Me.AsignarMensaje("El Tecnico Aci no ha Sido Asignado, Rechazar Solicitud!!!")
                    'Return -1
                    'Exit Function
                    'End If

                End If

                Try
                    If cSolicitud.ActualizarSolicitudCompra(Entidad, TipoConcurrencia.Pesimistica) < 1 Then
                        Me.AsignarMensaje("Error Al Actualizar Registro", True)
                        Return -1
                    Else
                        Me.ActualizarHistorico(Entidad)
                    End If
                Catch ex As Exception
                    Me.AsignarMensaje("Error al Actualizar :" + ex.Message, True)
                    Return -1
                End Try

                '' fecha: 5-noviembre-2012
                '' Buscar el codigo del empleado con cargo como Gerente de Finanzas
                '' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                'eMail = cEMPL.ObtenerDATO_INST("049")           'GERENTE FINANCIERO
                'eMail = cEMPL.ObtenerCodiOrgaEMPL(eMail)
                'eMail = cEMPL.ObtenereMailEncargadoCodiOrga(eMail)
                'lsSubject = " >> *Asignacion de Solicitud : " + Entidad.idSolicitudCompra.ToString + " Para ser aprobada."
                'lsBody = "Se le ha asignado la solicitud : " + Entidad.idSolicitudCompra.ToString & vbCrLf
                'lsBody = lsBody + "DESCRIPCION " + Entidad.observacion & vbCrLf
                'lsBody = lsBody + "Para aprobar debera de ingresar al sistema de Compras Menores " & vbCrLf & vbCrLf
                'lsBody = lsBody + "Atentamente," + vbCrLf
                EnviarCorreoNotificacion(Tipo, 2, "049", "")

            Case enumEstadosSolicitud.Verificacion_Presupuesto

                If Entidad Is Nothing Then
                    Me.AsignarMensaje("No Puede Finalizar Sin Almacenar Cambios")
                    Return -1
                Else
                    Entidad.fhInicioEstimado = Now
                    Entidad.fhFinEstimado = Now.AddDays(EstatusSolicitud.duracionDias)
                    Entidad.fhInicio = Now
                    'Se agrega nuevo flujo de acuerdo a Tipo de Solicitud de acuerdo a Ticket 4405 en fecha 03032023
                    If Entidad.idTipoSolicitud = "6" Then
                        Entidad.idEstatusSolicitud = enumEstadosSolicitud.Refuerzo_Complementario_Aprobado
                    Else
                        ''SE AGREGA EL TIPO DE SOLICITUD 7
                        ''TICKET 11022
                        ''EDUARDO RIVERA
                        If Entidad.idTipoSolicitud = "5" Or Entidad.idTipoSolicitud = "7" Then
                            Entidad.idEstatusSolicitud = enumEstadosSolicitud.Asignacion_Tecnico
                        Else
                            Entidad.idEstatusSolicitud = enumEstadosSolicitud.AprobacionSubDirector
                        End If
                    End If
                    Entidad.fhUltimaModificacion = Now
                    Entidad.usuarioModifica = Me.usuarioActualizacion
                    Entidad.jefeAutoriza = Me.codigoEmpleado
                    Entidad.idTecnicoACI = -1
                End If

                Try
                    If cSolicitud.ActualizarSolicitudCompra(Entidad, TipoConcurrencia.Pesimistica) < 1 Then
                        Me.AsignarMensaje("Error Al Actualizar Registro", True)
                        Return -1
                    Else
                        Me.ActualizarHistorico(Entidad)
                    End If
                Catch ex As Exception
                    Me.AsignarMensaje("Error al Actualizar :" + ex.Message, True)
                    Return -1
                End Try


                'eMail = cEMPL.ObtenerDATO_INST("085")       'SUBDIRECTOR EJECUTIVO
                'eMail = cEMPL.ObtenerCodiOrgaEMPL(eMail)
                'eMail = cEMPL.ObtenereMailEncargadoCodiOrga(eMail)
                'lsSubject = " >> *Asignacion de Solicitud : " + Entidad.idSolicitudCompra.ToString + " Para ser Autorizada."
                'lsBody = "Se le ha asignado la solicitud : " + Entidad.idSolicitudCompra.ToString & vbCrLf
                'lsBody = lsBody + "DESCRIPCION " + Entidad.observacion & vbCrLf
                'lsBody = lsBody + "Para aprobar debera de ingresar al sistema de Compras Menores " & vbCrLf & vbCrLf
                'lsBody = lsBody + "Atentamente," + vbCrLf
                EnviarCorreoNotificacion(Tipo, 2, "085", "")

            Case enumEstadosSolicitud.AprobacionSubDirector

                'Case enumEstadosSolicitud.Verificacion_Presupuesto

                If Entidad Is Nothing Then
                    Me.AsignarMensaje("No Puede Finalizar Sin Almacenar Cambios")
                    Return -1
                Else
                    Entidad.fhInicioEstimado = Now
                    Entidad.fhFinEstimado = Now.AddDays(EstatusSolicitud.duracionDias)
                    Entidad.fhInicio = Now
                    'SE CAMBIA FLUJO
                    ''SE AGREGA EL TIPO DE SOLICITUD 7
                    ''TICKET 11022
                    ''EDUARDO RIVERA
                    If Entidad.idTipoSolicitud = "5" Or Entidad.idTipoSolicitud = "7" Then
                        'Entidad.idEstatusSolicitud = enumEstadosSolicitud.Ingreso_de_Precio
                        Entidad.idEstatusSolicitud = enumEstadosSolicitud.Verificacion_Presupuesto
                    Else
                        Entidad.idEstatusSolicitud = enumEstadosSolicitud.Asignacion_Tecnico
                    End If
                    'Entidad.idEstatusSolicitud = enumEstadosSolicitud.Asignacion_Tecnico
                    Entidad.fhUltimaModificacion = Now
                    Entidad.usuarioModifica = Me.usuarioActualizacion
                    Entidad.jefeAutoriza = Me.codigoEmpleado
                    '
                    Entidad.idTecnicoACI = -1
                    '
                End If

                Try
                    If cSolicitud.ActualizarSolicitudCompra(Entidad, TipoConcurrencia.Pesimistica) < 1 Then
                        Me.AsignarMensaje("Error Al Actualizar Registro", True)
                        Return -1
                    Else
                        Me.ActualizarHistorico(Entidad)
                    End If
                Catch ex As Exception
                    Me.AsignarMensaje("Error al Actualizar :" + ex.Message, True)
                    Return -1
                End Try

            Case enumEstadosSolicitud.Ingreso_de_Precio

                'Case enumEstadosSolicitud.Verificacion_Presupuesto

                If Entidad Is Nothing Then
                    Me.AsignarMensaje("No Puede Finalizar Sin Almacenar Cambios")
                    Return -1
                Else
                    Entidad.fhInicioEstimado = Now
                    Entidad.fhFinEstimado = Now.AddDays(EstatusSolicitud.duracionDias)
                    Entidad.fhInicio = Now
                    'SE MODIFICA FLUJO
                    'Entidad.idEstatusSolicitud = enumEstadosSolicitud.Verificacion_Presupuesto
                    Entidad.idEstatusSolicitud = enumEstadosSolicitud.AprobacionSubDirector
                    Entidad.fhUltimaModificacion = Now
                    Entidad.usuarioModifica = Me.usuarioActualizacion
                    Entidad.jefeAutoriza = Me.codigoEmpleado
                    '
                    Entidad.idTecnicoACI = -1
                    '
                End If
                ''
                '' fecha: 21-agosto-2012
                '' Cuando se trata de Solicitudes de Procesos Administrativas COMPLEMENTARIAS
                '' el flujo sigue a asignar Tecnico Aci
                '' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                ''
                'If Entidad.idTipoEvento.ToString = "5" Then
                '    Entidad.idEstatusSolicitud = enumEstadosSolicitud.Asignacion_Tecnico
                'Else
                '    If Entidad.idTipoEvento.ToString = "9" Or Entidad.idTipoEvento.ToString = "10" Then
                '        Entidad.idEstatusSolicitud = enumEstadosSolicitud.Refuerzo_Complementario_Aprobado

                '        'Fecha:02/02/2017
                '        'Incidente : 31638
                '        'Se agregó un nuevo estado para las solicitudes de aumento
                '        'Realizado: Ivania Blanco
                '    ElseIf Entidad.idTipoEvento.ToString = "6" Then
                '        Entidad.idEstatusSolicitud = enumEstadosSolicitud.AprobacionDeReasignacion
                '        'Fin Modificacion

                '        'Fecha: 20/09/2019
                '        'Sistema a publicar: Procesos Administrativos
                '        'Base de datos: [Producción]
                '        'Publicación requerida por: Incidente :  50388
                '        'Realizar publicación: [Inmediata]
                '        'Reportado Por: Eduardo Rivera
                '        'Descripción:            ADECUAR EL SISTEMA PARA GENERAR PROCESOS A TRAVÉS DE BOLPROS.
                '        'Realizado Por: Ivania Blanco.
                '        'Aprobado Por: Eduardo Rivera.

                '    ElseIf Entidad.idTipoEvento.ToString = "11" Then
                '        Entidad.idEstatusSolicitud = enumEstadosSolicitud.ComisiónPendientedePago

                '        'Fecha:24/11/2020
                '        'Sistema: Procesos Administrativos
                '        'Base de datos: FISDL
                '        'Solicitud:#####
                '        'Solicitado Por: Armando Servellon
                '        'Descripción: Se solicita :  1.Modificar el formato de la Orden de Compra y que el(la) técnico(a) ACI tenga acceso a imprimirla (Ver formato anexo). 2.Para proyectos, que la ACI sea la responsable de la tarea para generar el número de contrato u orden de compra y en una segunda tarea que se agregue la opción para que se adjunte el contrato elaborado a sistema (esta última tarea siempre la continuara  realizando legal)
                '        '3.En la descripción de la orden de compra, habilitar un campo para agregar información extra. 
                '        'Realizado Por: Ivania Blanco.
                '        'Aprobado Por: Eduardo Rivera.
                '        'Cambio:Se agrega nuevo estado para el nuevo tipo de solicitud
                '    ElseIf Entidad.idTipoEvento.ToString = "13" Then
                '        Entidad.idEstatusSolicitud = enumEstadosSolicitud.DisponibilidadAprobada

                '    Else
                '        ' fecha: 7-septiembre-2015
                '        ' Solicitud: 653-2015
                '        ' Se cambia debido a que se envia a asignacion de tecnico aci
                '        ' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                '        '
                '        'Entidad.idEstatusSolicitud = enumEstadosSolicitud.En_Asignación_de_Proceso
                '        Entidad.idEstatusSolicitud = enumEstadosSolicitud.Asignacion_Tecnico
                '        '
                '    End If
                'End If
                ''
                '' fecha: 20-marzo-2013
                '' Cuando se solicitan por anticipos se cambia el estatus a "Pago de Anticipo"
                '' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                ''
                'If Entidad.idTipoEvento.ToString = "3" Then
                '    Entidad.idEstatusSolicitud = enumEstadosSolicitud.PagoDeAnticipo
                'End If
                ''

                Try
                    If cSolicitud.ActualizarSolicitudCompra(Entidad, TipoConcurrencia.Pesimistica) < 1 Then
                        Me.AsignarMensaje("Error Al Actualizar Registro", True)
                        Return -1
                    Else
                        Me.ActualizarHistorico(Entidad)
                    End If
                Catch ex As Exception
                    Me.AsignarMensaje("Error al Actualizar :" + ex.Message, True)
                    Return -1
                End Try

                ''eEmpl.CODI_EMPL = cEMPL.ObtenerCodiEmplPorCodiCarg("508")
                ''eEmpl = cEMPL.ObtenerEMPL(eEmpl.CODI_EMPL, False, True)
                ''eMail = eEmpl.USUA_MAIL_EXTE

                ''lsSubject = "Asignacion de Solicitud : " + Entidad.idSolicitudCompra.ToString + " Para ser aprobada."
                ''lsBody = "Se le ha asignado este dia la solicitud : " + Entidad.idSolicitudCompra.ToString & vbCrLf
                ''lsBody = lsBody + " DESCRIPCION " + Entidad.observacion & vbCrLf

                ''lsBody = lsBody + " Para aprobar debera de ingresar al sistema de SGA Compras Administrativas "

                ''lsBody = lsBody + "Atentamente," + vbCrLf
                ''
                '' fecha: 17-Septiembre-2012
                '' Se cambia el envio de correo cuando se trata de Ordenes Complementarias
                '' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                ''
                'If Entidad.idTipoEvento.ToString = "5" Then
                '    ''
                '    '' fecha: 21-enero-2013
                '    '' Incidente #8813.zl
                '    '' Reportado(por): MARITZA EVELIN LOPEZ.
                '    '' Descripción: AL FINALIZAR LA SOLICITUD DE COMPRAS NO ENVIA EL CORREO A LA ACI.
                '    '' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                '    ''
                '    '' --- Se envia correo al Jefe(a) ACI y al Supervisor ACI
                '    ''
                '    '' eEmpl.CODI_EMPL = cEMPL.ObtenerCodiEmplPorCodiCarg("737")
                '    ''
                '    '' eEmpl = cEMPL.ObtenerEMPL(eEmpl.CODI_EMPL, False, True)
                '    ''
                '    '' eMail = eEmpl.USUA_MAIL_EXTE
                '    ''
                '    'eEmpl.CODI_EMPL = cEMPL.ObtenerCodiEmplPorCodiCarg("752")
                '    ''
                '    'eEmpl = cEMPL.ObtenerEMPL(eEmpl.CODI_EMPL, False, True)
                '    ''
                '    '' eMail = eMail + ";" + eEmpl.USUA_MAIL_EXTE
                '    'eMail = eEmpl.USUA_MAIL_EXTE
                '    ''
                '    '' fecha: 7-febrero-2014
                '    '' Se agrega correo al empleado que elaboro la solicitud
                '    '' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                '    ''
                '    'eEmpl = cEMPL.ObtenerEMPL(Entidad.CODI_EMPL, False, True)
                '    'eMail = eMail + ";" + eEmpl.USUA_MAIL_EXTE
                '    ''

                '    eMail = cEMPL.ObtenerDATO_INST("084")
                '    eMail = cEMPL.ObtenerCodiOrgaEMPL(eMail)
                '    eMail = cEMPL.ObtenereMailEncargadoCodiOrga(eMail)


                'Else
                '    ' fecha: 7-febrero-2014
                '    ' Cuando es tipo Solicitud de Refuerzo Complementario no enviar correo a la ACI
                '    ' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                '    If Entidad.idTipoEvento.ToString <> "9" And Entidad.idTipoEvento.ToString <> "10" And Entidad.idTipoEvento.ToString <> "13" Then

                '        Dim tecnicoAci As TecnicoACI
                '        Dim cTecnicoACI As New cTecnicoACI
                '        tecnicoAci = cTecnicoACI.ObtenerTecnicoACI(Entidad.idTecnicoACI)

                '        eEmpl.CODI_EMPL = tecnicoAci.CODI_EMPL
                '        eEmpl = cEMPL.ObtenerEMPL(eEmpl, False, False)
                '        eMail = eEmpl.USUA_MAIL_EXTE
                '    End If
                'End If
                ''
                '' fecha: 20-marzo-2013
                '' Cuando se solicitan por anticipos se cambia el estatus a "Pago de Anticipo"
                '' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                ''
                'If Entidad.idTipoEvento.ToString = "3" Then
                '    '
                '    eEmpl.CODI_EMPL = Entidad.CODI_EMPL
                '    eEmpl = cEMPL.ObtenerEMPL(eEmpl, False, False)
                '    eMail = eEmpl.USUA_MAIL_EXTE
                '    '
                '    ' fecha: 4-abril-2013
                '    ' Se agrega envio de correo al tecnico de egresos para el pago de anticipo
                '    ' Realizado: rICARDO eRNESTO hERNANDEZ
                '    eEmpl.CODI_EMPL = cEMPL.ObtenerCodiEmplPorCodiCarg("763")
                '    '
                '    eEmpl = cEMPL.ObtenerEMPL(eEmpl.CODI_EMPL, False, True)
                '    '
                '    eMail = eMail + ";" + eEmpl.USUA_MAIL_EXTE
                '    '
                'End If
                ''
                'If Entidad.idTipoEvento.ToString = "5" Then
                '    lsSubject = " >> Asignacion de Solicitud : " + Entidad.idSolicitudCompra.ToString + " Para Asignación de TECNICO ACI."
                'Else
                '    If Entidad.idTipoEvento.ToString = "9" Or Entidad.idTipoEvento.ToString = "10" Then
                '        lsSubject = " >> Solicitud : " + Entidad.idSolicitudCompra.ToString + " Se aprobo para el PROCESO DE PAGO."
                '    Else
                '        lsSubject = " >> Asignacion de Solicitud : " + Entidad.idSolicitudCompra.ToString + " Para ser creado su PROCESO DE ADQUISICION."
                '    End If
                'End If
                ''
                '' fecha: 20-marzo-2013
                '' Cuando se solicitan por anticipos se cambia el estatus a "Pago de Anticipo"
                '' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                ''
                'If Entidad.idTipoEvento.ToString = "3" Then
                '    lsSubject = " >> Solicitud : " + Entidad.idSolicitudCompra.ToString + " Aprobada para Pago de Anticipo."
                'End If
                ''
                'lsBody = "Se le ha asignado la solicitud : " + Entidad.idSolicitudCompra.ToString & vbCrLf
                'lsBody = lsBody + " DESCRIPCION " + Entidad.observacion & vbCrLf
                ''
                '' fecha: 20-marzo-2013
                '' Cuando se solicitan por anticipos se cambia el estatus a "Pago de Anticipo"
                '' Realizado: rICARDO eRNESTO hERNANDEZ zELAYA
                ''
                'If Entidad.idTipoEvento.ToString = "3" Then ' 3 = Pago de Anticipo
                '    lsBody = lsBody + " Solicitud aprobada " & vbCrLf
                'Else
                '    If Entidad.idTipoEvento.ToString = "9" Or Entidad.idTipoEvento.ToString = "10" Then
                '        lsBody = lsBody + " Solicitud aprobada para tramite de pago " & vbCrLf
                '    Else
                '        lsBody = lsBody + " Para aprobar debera de ingresar al sistema de Compras Menores " & vbCrLf
                '    End If
                'End If
                ''
                'lsBody = lsBody + "Atentamente," + vbCrLf
                '

                'eMail = cEMPL.ObtenerDATO_INST("084")
                'eMail = cEMPL.ObtenerCodiOrgaEMPL(eMail)
                'eMail = cEMPL.ObtenereMailEncargadoCodiOrga(eMail)
                'lsSubject = " >> *Asignacion de Solicitud : " + Entidad.idSolicitudCompra.ToString + " Para ser Autorizada."
                'lsBody = "Se le ha asignado la solicitud : " + Entidad.idSolicitudCompra.ToString & vbCrLf
                'lsBody = lsBody + "DESCRIPCION " + Entidad.observacion & vbCrLf
                'lsBody = lsBody + "Para aprobar debera de ingresar al sistema de Compras Menores " & vbCrLf & vbCrLf
                'lsBody = lsBody + "Atentamente," + vbCrLf
                EnviarCorreoNotificacion(Tipo, 2, "084", "019")

        End Select

        ''If eMail <> "" Then
        ''    eMail = "rmontenegro@fisdl.gob.sv"
        'If FuncionesMail.EnviarMail(eMail, "aplicacionesnet@fisdl.gob.sv", lsSubject, lsBody, "", "", "rmontenegro@fisdl.gob.sv") = -1 Then
        '    Me.AsignarMensaje("No se Pudo Enviar Correo electronico!!!, Avisar a Sistemas", False)
        '    'Return 0
        'End If
        ''End If
        Return 1

    End Function
