import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {
  COMPLAINT_DELETE,
  COMPLAINT_ITEMS,
  COMPLAINT_SAVE, COMPLAINT_VIEW
} from "../../config/system.url";
import {Paginate} from "../../entity/server-response";
import {SystemComplaint} from "../../entity/system";

@Injectable({
  providedIn: 'root'
})
export class ComplaintService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1, query?: SystemComplaint) {
    return this.http.httpPost<Paginate<SystemComplaint>>(`${COMPLAINT_ITEMS}?page=${page}`, query)
  }

  public save(postData: SystemComplaint) {
    return this.http.httpPost(COMPLAINT_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<SystemComplaint>(COMPLAINT_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(COMPLAINT_DELETE, {id})
  }
}
