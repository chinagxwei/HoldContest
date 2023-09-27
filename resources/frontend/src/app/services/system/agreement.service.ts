import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {
  AGREEMENT_DELETE,
  AGREEMENT_ITEMS,
  AGREEMENT_SAVE, AGREEMENT_VIEW,
} from "../../config/system.url";
import {Paginate} from "../../entity/server-response";
import {SystemAgreement} from "../../entity/system";

@Injectable({
  providedIn: 'root'
})
export class AgreementService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<SystemAgreement>>(`${AGREEMENT_ITEMS}?page=${page}`)
  }

  public save(postData: SystemAgreement) {
    return this.http.httpPost(AGREEMENT_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<SystemAgreement>(AGREEMENT_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(AGREEMENT_DELETE, {id})
  }
}
