import { TestBed } from '@angular/core/testing';

import { MemberQuestService } from './member-quest.service';

describe('MemberQuestService', () => {
  let service: MemberQuestService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MemberQuestService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
