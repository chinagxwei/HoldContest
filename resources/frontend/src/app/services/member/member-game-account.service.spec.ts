import { TestBed } from '@angular/core/testing';

import { MemberGameAccountService } from './member-game-account.service';

describe('MemberGameAccountService', () => {
  let service: MemberGameAccountService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MemberGameAccountService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
