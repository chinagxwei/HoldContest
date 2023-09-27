import { TestBed } from '@angular/core/testing';

import { MemberPrizeLogService } from './member-prize-log.service';

describe('MemberPrizeLogService', () => {
  let service: MemberPrizeLogService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MemberPrizeLogService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
