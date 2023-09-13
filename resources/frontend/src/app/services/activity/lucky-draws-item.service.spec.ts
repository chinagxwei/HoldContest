import { TestBed } from '@angular/core/testing';

import { LuckyDrawsItemService } from './lucky-draws-item.service';

describe('LuckyDrawsItemService', () => {
  let service: LuckyDrawsItemService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(LuckyDrawsItemService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
