import { NbMenuItem } from '@nebular/theme';

export const MENU_ITEMS: NbMenuItem[] = [
  {
    title: 'Dashboard',
    icon: 'nb-home',
    link: '/pages/dashboard',
    home: true,
  },
  {
    title: 'Lu5',
    icon: 'nb-gear',
    children: [
      {
        title: 'Facebook',
        link: '/pages/lu5/facebook',
      },
      {
        title: 'Twitter',
        link: '/pages/lu5/twitter',
      },
      {
        title: 'Instagram',
        link: '/pages/lu5/instagram',
      }, 
      {
        title: 'Youtube',
        link: '/pages/lu5youtube/youtube',
      }, 
    ],
  },
  {
    title: 'Lmneuquen',
    icon: 'nb-gear',
    children: [
      {
        title: 'Facebook',
        link: '/pages/lmneuquen/facebook',
      },
      {
        title: 'Twitter',
        link: '/pages/lmneuquen/twitter',
      },
      {
        title: 'Instagram',
        link: '/pages/lmneuquen/instagram',
      },  
    ],
  },
  {
    title: 'Lmcipolletti',
    icon: 'nb-gear',
    children: [
      {
        title: 'Facebook',
        link: '/pages/lmcipolletti/facebook',
      },
      {
        title: 'Twitter',
        link: '/pages/lmcipolletti/twitter',
      },
      {
        title: 'Instagram',
        link: '/pages/lmcipolletti/instagram',
      },  
    ],
  },
  {
    title: 'Importaciones',
    icon: 'ion-ios-cloud-upload',
    children: [
      {
        title: 'Gestionar Eventos',
        link: '/pages/importar/gestion_eventos',
      },
      {
        title: 'Importar',
        link: '/pages/importar/importar',
      },
      {
        title: 'Usuarios',
        link: '/pages/importar/usuarios',
      },
    ],
  },
  {
    title: 'Agendas',
    icon: 'ion-ios-paper',
    children: [
      {
        title: 'Gestionar Agendas',
        link: '/pages/agendas/gestion_eventos',
      },
      {
        title: 'Importar Agenda',
        link: '/pages/agendas/importar',
      }, 
    ],
  },
  {
    title: 'Clientes',
    icon: 'ion-ios-people-outline',
    link: '/pages/clientes',
  },
  {
    title: 'Login',
    icon: 'nb-locked',
    link: '/pagessinples/loginf',
    home: true,
  },
  /*
  {
    title: 'FEATURES',
    group: true,
  },
  {
    title: 'UI Features',
    icon: 'nb-keypad',
    link: '/pages/ui-features',
    children: [
      {
        title: 'Buttons',
        link: '/pages/ui-features/buttons',
      },
      {
        title: 'Grid',
        link: '/pages/ui-features/grid',
      },
      {
        title: 'Icons',
        link: '/pages/ui-features/icons',
      },
      {
        title: 'Modals',
        link: '/pages/ui-features/modals',
      },
      {
        title: 'Typography',
        link: '/pages/ui-features/typography',
      },
      {
        title: 'Animated Searches',
        link: '/pages/ui-features/search-fields',
      },
      {
        title: 'Tabs',
        link: '/pages/ui-features/tabs',
      },
    ],
  },
  {
    title: 'Forms',
    icon: 'nb-compose',
    children: [
      {
        title: 'Form Inputs',
        link: '/pages/forms/inputs',
      },
      {
        title: 'Form Layouts',
        link: '/pages/forms/layouts',
      },
    ],
  },

  {
    title: 'Components',
    icon: 'nb-gear',
    children: [
      {
        title: 'Tree',
        link: '/pages/components/tree',
      }, {
        title: 'Notifications',
        link: '/pages/components/notifications',
      },
    ],
  },
  {
    title: 'Maps',
    icon: 'nb-location',
    children: [
      {
        title: 'Google Maps',
        link: '/pages/maps/gmaps',
      },
      {
        title: 'Leaflet Maps',
        link: '/pages/maps/leaflet',
      },
      {
        title: 'Bubble Maps',
        link: '/pages/maps/bubble',
      },
    ],
  },
  {
    title: 'Charts',
    icon: 'nb-bar-chart',
    children: [
      {
        title: 'Echarts',
        link: '/pages/charts/echarts',
      },
      {
        title: 'Charts.js',
        link: '/pages/charts/chartjs',
      },
      {
        title: 'D3',
        link: '/pages/charts/d3',
      },
    ],
  },
  {
    title: 'Editors',
    icon: 'nb-title',
    children: [
      {
        title: 'TinyMCE',
        link: '/pages/editors/tinymce',
      },
      {
        title: 'CKEditor',
        link: '/pages/editors/ckeditor',
      },
    ],
  },
  {
    title: 'Tables',
    icon: 'nb-tables',
    children: [
      {
        title: 'Smart Table',
        link: '/pages/tables/smart-table',
      },
    ],
  },
  {
    title: 'Auth',
    icon: 'nb-locked',
    children: [
      {
        title: 'Login',
        link: '/auth/login',
      },
      {
        title: 'Register',
        link: '/auth/register',
      },
      {
        title: 'Request Password',
        link: '/auth/request-password',
      },
      {
        title: 'Reset Password',
        link: '/auth/reset-password',
      },
    ],
  },*/
];
