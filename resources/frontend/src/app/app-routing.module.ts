import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {AdminGuard} from "./guard/admin.guard";

const routes: Routes = [
  {path: '', pathMatch: 'full', redirectTo: '/platform'},
  {
    path: 'login',
    loadChildren: () => import('./pages/auth/auth.module').then(m => m.AuthModule),
  },
  {
    path: 'platform',
    loadChildren: () => import('./pages/platform/platform.module').then(m => m.PlatformModule),
    canLoad: [AdminGuard]
  },
  {path: '**', redirectTo: '/', pathMatch: 'full'},
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {useHash: false})],
  exports: [RouterModule]
})
export class AppRoutingModule {
}
