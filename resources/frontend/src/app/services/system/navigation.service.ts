import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {
  NAVIGATION_ALL_ITEMS,
  NAVIGATION_DELETE,
  NAVIGATION_ITEMS,
  NAVIGATION_SAVE,
  NAVIGATION_SORT
} from "../../config/system.url";
import {Paginate} from "../../entity/server-response";
import {Navigation} from "../../entity/system";

@Injectable({
  providedIn: 'root'
})
export class NavigationService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<Navigation>>(`${NAVIGATION_ITEMS}?page=${page}`);
  }

  public save(navigation: Navigation) {
    return this.http.httpPost(NAVIGATION_SAVE, navigation);
  }

  public delete(id: number) {
    return this.http.httpPost(NAVIGATION_DELETE, {id});
  }

  public sort(sortItems: { id: number, sort: number }[]) {
    return this.http.httpPost(NAVIGATION_SORT, sortItems);
  }

  public all() {
    return this.http.httpPost<Navigation[]>(NAVIGATION_ALL_ITEMS);
  }
}
