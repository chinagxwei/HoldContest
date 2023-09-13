import {RouterModule, Routes} from '@angular/router';
import {NgModule} from '@angular/core';
import {LoginComponent} from './login/login.component';

const authRoutes: Routes = [
  {path: '', component: LoginComponent}
];

@NgModule({
  imports: [
    RouterModule.forChild(authRoutes)
  ],
  exports: [
    RouterModule
  ]
})
export class AuthRoutingModule {
}
