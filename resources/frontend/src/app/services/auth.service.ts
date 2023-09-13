import {HttpClient, HttpHeaders} from "@angular/common/http";
import {NavigationExtras, Router} from "@angular/router";
import {AuthenticationRequest, User} from "../entity/user";
import {ServerResponse} from "../entity/server-response";
import {map} from "rxjs";
import * as moment from "moment";
import {USER_LOGIN, USER_LOGOUT} from "../config/system.url";
import {Injectable} from "@angular/core";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  public user?: User;

  public redirectUrl: string = "";

  public defaultUrl = '/platform'

  constructor(
    private router: Router,
    private http: HttpClient
  ) {
    const dataStr = window.localStorage.getItem('backend_authorized');
    if (dataStr && dataStr?.length > 0) {
      this.user = JSON.parse(dataStr) as User;
    }
  }

  public login(loginInfo: AuthenticationRequest | { code: string }) {
    return this.http
      .post<ServerResponse<User>>(USER_LOGIN, loginInfo)
      .pipe(
        map(res => {
          if (res.code === 200) {
            this.user = res.data;
            this.localLogin();
            return {type:true,msg:res.message};
          } else {
            return {type:false,msg:res.message};
          }
        })
      );
  }

  public localLogin() {
    if (this.user) {
      if (!this.isExpiresIn) {
        this.localLogout();
      } else {
        window.localStorage.setItem('backend_authorized', JSON.stringify(this.user));
        const redirect = this.redirectUrl ? this.router.parseUrl(this.redirectUrl) : this.defaultUrl;
        const navigationExtras: NavigationExtras = {
          queryParamsHandling: 'preserve',
          preserveFragment: true
        };
        this.router.navigateByUrl(redirect, navigationExtras);
      }
    }
  }

  get isExpiresIn(): boolean {
    // @ts-ignore
    return this.user?.expires_in > moment().unix();
  }

  get isLogin(): boolean {
    return !!this.user;
  }

    get username() {
        return this.user?.userinfo?.nickname;
    }

    get navigations() {
        return this.user?.userinfo?.role?.navigations
    }

  public logout() {
    return this.http
      .post<ServerResponse<undefined>>(USER_LOGOUT, null, this.getHttpHeaders())
  }

  public localLogout() {
    const navigationExtras: NavigationExtras = {
      queryParams: {type: 'logout'},
    };
    if (this.isExpiresIn) {
      this.logout().subscribe(() => {
        this.user = undefined;
        window.localStorage.removeItem('backend_authorized');
        this.router.navigate(['/login'], navigationExtras);
      })
    } else {
      window.localStorage.removeItem('backend_authorized');
      this.router.navigate(['/login'], navigationExtras);
    }
  }

  private getHttpHeaders() {
    const httpOptions = {
      headers: new HttpHeaders({})
    }
    httpOptions.headers = httpOptions.headers.set('Authorization', `Bearer ${this.user?.access_token}`);
    return httpOptions;
  }
}
