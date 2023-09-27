import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {Unit} from "../../entity/system";
import {
  UNIT_DELETE,
  UNIT_LIST,
  UNIT_SAVE,
  UNIT_VIEW
} from "../../config/system.url";

@Injectable({
  providedIn: 'root'
})
export class UnitService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<Unit>>(`${UNIT_LIST}?page=${page}`)
  }

  public save(postData: Unit) {
    return this.http.httpPost(UNIT_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<Unit>(UNIT_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(UNIT_DELETE, {id})
  }
}
