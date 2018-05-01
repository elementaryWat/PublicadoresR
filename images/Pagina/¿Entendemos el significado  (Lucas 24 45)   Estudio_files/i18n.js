(function(window) {
   var literals = {
      CMSPUBS: {
         'HdgCitedScripture': 'Pasaje bíblico citado',
         'HdgDownload': 'Descargar',
         'HdgFootnote': 'Nota',
         'HdgFootnotes': 'Notas',
         'HdgGlossaryTerm': 'Expresión del glosario',
         'HdgMarginalReferences': 'Referencias marginales',
         'HdgPlayOrDownload': 'REPRODUCIR O DESCARGAR',
         'HdgVidSegments': 'Video',
         'LblDispSubttl': 'MOSTRAR SUBTÍTULOS',
         'LblLanguage': 'Idioma:',
         'LblPlay': 'Reproducir',
         'LnkOpenUppCase': 'ABRIR',
         'LnkCloseUppCase': 'CERRAR',
         'LnkShowMenu': 'MOSTRAR MENÚ',
         'LnkHideMenu': 'OCULTAR MENÚ',
         'LnkDisableScreenReader': 'Desactivar modo de accesibilidad',
         'LnkEnableScreenReader': 'Activar modo de accesibilidad',
         'LnkEnlargeScroll': 'Haga clic para agrandar o mover la información en pantalla',
         'LnkMoreAboutThisVid': 'Más información sobre este video',
         'MediaPlayerFullScreen': 'Pantalla completa',
         'OptLanguage': 'Elegir idioma',
         'TxtNoFilesErr': 'Lo sentimos, no se pudo acceder a los archivos. Inténtelo más adelante.',
         'TxtNoFlash': 'Para ver el contenido de esta página se requiere una versión más reciente del programa Flash Player de Adobe.',
         'TxtPlayerFailed': 'Lo sentimos. El reproductor multimedia no pudo cargarse.',
         'TxtUpdateFlash': 'Haga clic para descargar Flash Player de Adobe',
         'VidRecDnldOpt': 'Opciones de descarga de grabaciones de video',
         'LnkTtlAttPlay': 'Reproducir',
         'LnkTtlAttPause': 'Pausar',
         'LnkTtlAttMute': 'Desactivar voz',
         'LnkTtlAttUnmute': 'Activar voz',
         'LnkTtlAttPlayDnld': 'Reproducir o descargar',
         'TxtStrmAudNotAvailable': 'En este momento no&nbsp;es posible escuchar el archivo de audio sin&nbsp;descargarlo.',
         'MsgUpdatedTermsAlert': 'Al usar este sitio, se está comprometiendo a respetar nuestras nuevas condiciones para el uso legal del contenido protegido por derechos de autor.',
         'MediaPlayerGeneralErr': '<p > Error: Se necesita Flash </p> <p > Instale Flash o inténtelo con otro navegador. </p>',
         'LblGo': 'Buscar'
      }
   };

   window._t = function(id) {
      id = id.split('.');
      return literals[id[0]][id[1]];
   };

   window._t.literals = literals;
}(window));
