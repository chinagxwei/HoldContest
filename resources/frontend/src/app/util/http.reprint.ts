import {HttpClient, HttpHeaders} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Injectable} from '@angular/core';
import {tap} from 'rxjs/operators';
import {NzModalService} from "ng-zorro-antd/modal";
import {ServerResponse} from "../entity/server-response";
import {AuthService} from "../services/auth.service";


@Injectable({
  providedIn: 'root'
})
export class HttpReprint {

  httpOptions = {
    headers: new HttpHeaders({})
  };

  constructor(
    private http: HttpClient,
    private authService: AuthService,
    private modal: NzModalService) {
  }


  public setHeader(name: string, value: string): HttpReprint {
    this.httpOptions.headers = this.httpOptions.headers.set(name, value);
    return this;
  }

  public originalHttpPost<T>(url: string, body?: any) {
    return this.http
      .post<ServerResponse<T>>(url, body);
  }

  public originalHttpGet<T>(url: string) {
    return this.http
      .get<ServerResponse<T>>(url);
  }

  public httpPost<T>(url: string, body?: any): Observable<ServerResponse<T>> {
    this.httpOptions.headers = this.httpOptions.headers.set('Authorization', `Bearer ${this.authService?.user?.access_token}`);
    return this.http
      .post<ServerResponse<T>>(url, body, this.httpOptions)
      .pipe(
        tap(value => {
            if (value.code === ResponseCode.NOT_LOGIN || !this.authService.isExpiresIn) {
              this.alert('登录超时');
              this.authService.localLogout();
            }
          }
        )
      );
  }

  public httpGet<T>(url: string): Observable<ServerResponse<T>> {
    this.httpOptions.headers = this.httpOptions.headers.set('Authorization', `Bearer ${this.authService?.user?.access_token}`);
    return this.http
      .get<ServerResponse<T>>(url, this.httpOptions)
      .pipe(
        tap(value => {
            if (value.code === ResponseCode.NOT_LOGIN || !this.authService.isExpiresIn) {
              this.alert('登录超时');
              this.authService.localLogout();
            }
          }
        )
      );
  }

  private alert(message: string) {
    this.modal.error({
      nzTitle: '错误',
      nzContent: message
    });
  }
}

export enum ResponseCode {
  RESPONSE_SUCCESS = 1,
  RESPONSE_ERROR = 0,
  USER_NOT_FOUND = -1,
  USER_NOT_USED = -2,
  USER_PASSWORD_ERROR = -3,
  PERMISSION_DENIED = -101,
  NOT_LOGIN = 401
}
