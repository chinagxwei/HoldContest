import { Injectable } from '@angular/core';
import {
  ActivatedRouteSnapshot,
  CanActivate,
  CanActivateChild,
  CanLoad, NavigationExtras,
  Route,
  Router,
  RouterStateSnapshot,
  UrlSegment,
  UrlTree
} from '@angular/router';
import { Observable } from 'rxjs';
import {AuthService} from "../services/auth.service";

@Injectable({
  providedIn: 'root'
})
export class AdminGuard implements CanActivate, CanActivateChild, CanLoad {


  constructor(
    private router: Router,
    private authService: AuthService
  ) {
  }

  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {
    const url: string = state.url;
    return this.serverCheckLogin(url);
  }
  canActivateChild(
    childRoute: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {
    return this.canActivate(childRoute, state);
  }
  canLoad(
    route: Route,
    segments: UrlSegment[]): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {
    const url = `/${route.path}`;
    return this.serverCheckLogin(url);
  }

  serverCheckLogin(url: string): Observable<boolean> {
    const nav = this.authService.navigations;
    // console.log(nav);
    if (nav){
      // @ts-ignore
      const res = nav.find(v => {
        // console.log(url)
        if (v.children && v.children.length > 0) {
          return v.children.find(v2 => {
            return `/${v2.navigation_router}` === url || this.authService.defaultUrl === url
          })
        } else {
          return `/${v.navigation_router}` === url || this.authService.defaultUrl === url
        }
      });
      if (res === undefined || res === null){
        this.router.navigate([this.authService.defaultUrl]);
      }
    }
    if (this.authService.user && this.authService.isExpiresIn) {
      // return this.userService.ping();
      return new Observable<boolean>(subscriber => {
        subscriber.next(true);
        subscriber.complete();
      });
    } else {
      this.authService.localLogout();
    }

    const navigationExtras: NavigationExtras = {
      queryParams: {type: 'login'},
    };
    this.router.navigate(['/login'], navigationExtras);
    return new Observable<boolean>(subscriber => {
      subscriber.next(false);
      subscriber.complete();
    });
  }
}
