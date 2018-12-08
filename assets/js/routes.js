import Index from './components/Index';
import Dashboard from './components/Dashboard';

const routes = [
  { path: '/', component: Index },
  { path: '/dashboard', component: Dashboard },
  { path: '/dashboard/:file_id', component: Dashboard },
];

export default routes;
