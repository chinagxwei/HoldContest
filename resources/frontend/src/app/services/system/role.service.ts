import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {
  ROLE_CONFIG_MENU,
  ROLE_DELETE,
  ROLE_ITEMS,
  ROLE_SAVE,
  ROLE_SEARCH,
  ROLE_VIEW
} from "../../config/system.url";
import {BehaviorSubject, debounceTime, switchMap} from "rxjs";
import {Paginate} from "../../entity/server-response";
import {Role} from "../../entity/system";

@Injectable({
  providedIn: 'root'
})
export class RoleService {

  searchChange$ = new BehaviorSubject('');

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<Role>>(`${ROLE_ITEMS}?page=${page}`)
  }

  public view(id: number = 1) {
    return this.http.httpPost<Role>(`${ROLE_VIEW}?id=${id}`)
  }

  public save(role: Role) {
    return this.http.httpPost(ROLE_SAVE, role)
  }

  public delete(id: number) {
    return this.http.httpPost(ROLE_DELETE, {id})
  }

  public configMenu(config: { role: number, menus: number[], type: number }) {
    return this.http.httpPost(ROLE_CONFIG_MENU, config)
  }

  public search(keyword: string) {
    return this.searchChange$
      .asObservable()
      .pipe(debounceTime(500))
      .pipe(switchMap(() => this.http.httpPost<Paginate<Role>>(ROLE_SEARCH, {keyword})));
  }
}
