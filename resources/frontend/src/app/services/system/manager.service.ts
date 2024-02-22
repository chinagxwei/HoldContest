import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";

import {
  ActionLog,
  AuthenticationRequest,
  ResetPasswordRequest,
  ServerManager,
  UpdateUserInfoRequest
} from "../../entity/user";
import {Paginate, ServerResponse} from "../../entity/server-response";
import {
  ADMIN_ACTION_LOG,
  MANAGER_DELETE,
  MANAGER_ITEMS,
  MANAGER_SAVE,
  MANAGER_VIEW,
  USER_RESET_PASSWORD
} from "../../config/system.url";

@Injectable({
  providedIn: 'root'
})
export class ManagerService {

  constructor(private http: HttpReprint) {
  }

  public items<T>(page: number = 1) {
    return this.http.httpPost<T>(`${MANAGER_ITEMS}?page=${page}`)
  }

  public save(user: AuthenticationRequest | UpdateUserInfoRequest) {
    return this.http.httpPost(MANAGER_SAVE, user)
  }

  public view(id: number) {
    return this.http.httpPost<ServerManager>(MANAGER_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(MANAGER_DELETE, {id})
  }

  public resetPassword(reset: ResetPasswordRequest) {
    return this.http.httpPost(`${USER_RESET_PASSWORD}`, reset)
  }

  public actionLog(page: number = 1) {
    return this.http.httpPost<Paginate<ActionLog>>(`${ADMIN_ACTION_LOG}?page=${page}`)
  }
}
