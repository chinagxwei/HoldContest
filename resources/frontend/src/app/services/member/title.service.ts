import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {Title} from "../../entity/member";
import {TITLE_DELETE, TITLE_LIST, TITLE_SAVE, TITLE_VIEW} from "../../config/member.url";

@Injectable({
  providedIn: 'root'
})
export class TitleService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1, query?: Title) {
    return this.http.httpPost<Paginate<Title>>(`${TITLE_LIST}?page=${page}`, query)
  }

  public save(postData: Title) {
    return this.http.httpPost(TITLE_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<Title>(TITLE_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(TITLE_DELETE, {id})
  }
}
