import { TestBed } from '@angular/core/testing';

import { CompetitionRuleService } from './competition-rule.service';

describe('CompetitionRuleService', () => {
  let service: CompetitionRuleService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CompetitionRuleService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
